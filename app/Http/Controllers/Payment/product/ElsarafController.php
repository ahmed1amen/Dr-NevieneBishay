<?php

namespace App\Http\Controllers\Payment\product;

use App\BasicSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use App\ProductOrder;
use App\OrderItem;
use App\Product;
use App\ShippingCharge;
use Carbon\Carbon;
use App\PaymentGateway;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use Mail;
use PDF;
use Auth;


class ElsarafController extends Controller
{

    private $_api_context;
    private $Elsaraf_data;

    public function __construct()
    {
        $data = PaymentGateway::find(20);
        $this->Elsaraf_data = $data->convertAutoData();

    }

    function callAPI($call_uri, $method, $data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $call_uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
            CURLOPT_POSTFIELDS => json_encode($data),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function store(Request $request)
    {

        if (!Session::has('cart')) {
            return view('errors.404');
        }


        $cart = Session::get('cart');
        $itemsArray = [];

        $total = 0;
        foreach ($cart as $id => $item) {

            $product = Product::findOrFail($id);

            if ($product->stock < $item['qty']) {
                Session::flash('stock_error', $product->title . ' stock not available');
                return back();
            }
            $total += $product->current_price * $item['qty'];

            array_push($itemsArray, [
                "itemId" => $id,
                "name" => $item['name'],
                "description" => $item['name'],
                "quantity" => $item['qty'],
                "price" => $product->current_price,
            ]);
        }

        if ($request->shipping_charge != 0) {
            $shipping = ShippingCharge::findOrFail($request->shipping_charge);
            $shippig_charge = $shipping->charge;
        } else {
            $shippig_charge = 0;
        }

        $total = round($total, 2);


        $request->validate([
            'billing_fname' => 'required',
            'billing_lname' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_country' => 'required',
            'billing_number' => 'required',
            'billing_email' => 'required',
            'shpping_fname' => 'required',
            'shpping_lname' => 'required',
            'shpping_address' => 'required',
            'shpping_city' => 'required',
            'shpping_country' => 'required',
            'shpping_number' => 'required',
            'shpping_email' => 'required',
        ]);

        $input = $request->all();

        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extra;

        $title = 'Product Checkout';

        $order['order_number'] = str_random(4) . time();

        $order['order_amount'] = round($total, 2);

        $cancel_url = action('Payment\product\ElsarafController@paycancle');
        $notify_url = route('product.elsaraf.notify');
        $success_url = action('Payment\product\ElsarafController@payreturn');

        $total = round(($total / $bex->base_currency_rate), 2);


        $info = [
            'api_token' => $this->Elsaraf_data['merchantsecret'],
            'customer' => [
                'customerName' => $request->get('billing_fname'),
                'customerMobile' => $request->get('billing_lname'),
                'customerEmail' => auth()->user()->email,
            ],
            'interaction' => [
                'cancelUrl' => $cancel_url,
                'returnUrl' => $success_url,
                'timeoutUrl' => 'http://timeoutUrl.com'
            ],
            'invoice' => [
                'items' => $itemsArray,
                "shipping" => $shippig_charge,
                "tax" => 0,
            ],
            'currency' => 'EGP',
            'currencySymbol' => 'EGP',
            'locale' => app()->getLocale()

        ];
        $response = json_decode($this->callAPI("https://accept.elsaraf.com/api/init", "POST", $info), true);
        if (isset($response['url'])) {
            Session::put('elsaraf_data', $input);
            Session::put('order_data', $order);
            Session::put('elsaraf_payment_id', $response['orderId']);
            return Redirect::away($response['url']);
        } else
            redirect()->back()->with('unsuccess', 'Unknown error occurred');

    }

    public function paycancle()
    {

        return redirect()->back()->with('unsuccess', 'Payment Cancelled.');
    }

    public function payreturn(Request  $request)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $this->notify($request);
        return view('front.product.success', $data);
    }


    public function notify(Request $request)
    {
        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extra;
        $be = $currentLang->basic_extended;

        $elsaraf_data = Session::get('elsaraf_data');


        $order_data = Session::get('order_data');

        $success_url = action('Payment\product\ElsarafController@payreturn');
        $cancel_url = action('Payment\product\ElsarafController@paycancle');

        /** Get the payment ID before session clear **/
        $payment_id = Session::get('elsaraf_payment_id');
        /** clear the session payment ID **/



        $data = [
            'api_token' => $this->Elsaraf_data['merchantsecret'],
        ];

        $api_response = json_decode($this->callAPI("https://accept.elsaraf.com/api/retrieveOrder/" . $payment_id, "POST", $data), true);
        if (isset($api_response['data'])) {

            $cart = Session::get('cart');

            $total = 0;
            foreach ($cart as $id => $item) {
                $product = Product::findOrFail($id);
                if ($product->stock < $item['qty']) {
                    Session::flash('error', $product->title . ' stock not available');
                    return back();
                }
                $total += $product->current_price * $item['qty'];
            }

            if ($elsaraf_data['shipping_charge'] != 0) {
                $shipping = ShippingCharge::findOrFail($elsaraf_data['shipping_charge']);
                $shippig_charge = $shipping->charge;
            } else {
                $shippig_charge = 0;
            }

            $total = round($total + $shippig_charge, 2);


            $order = new ProductOrder;
            $order->billing_fname = $elsaraf_data['billing_fname'];
            $order->billing_lname = $elsaraf_data['billing_lname'];
            $order->billing_email = $elsaraf_data['billing_email'];
            $order->billing_address = $elsaraf_data['billing_address'];
            $order->billing_city = $elsaraf_data['billing_city'];
            $order->billing_country = $elsaraf_data['billing_country'];
            $order->billing_number = $elsaraf_data['billing_number'];
            $order->shpping_fname = $elsaraf_data['shpping_fname'];
            $order->shpping_lname = $elsaraf_data['shpping_lname'];
            $order->shpping_email = $elsaraf_data['shpping_email'];
            $order->shpping_address = $elsaraf_data['shpping_address'];
            $order->shpping_city = $elsaraf_data['shpping_city'];
            $order->shpping_country = $elsaraf_data['shpping_country'];
            $order->shpping_number = $elsaraf_data['shpping_number'];


            $order->total = round($order_data['order_amount'], 2);
            $order->shipping_charge = round($shippig_charge, 2);
            $order->method = $elsaraf_data['method'];
            $order->currency_code = $bex->base_currency_text;
            $order['order_number'] = $order_data['order_number'];
            $order['payment_status'] = "Completed";
            $order['txnid'] = $api_response['data']['id'];
            $order['charge_id'] =  $api_response['data']['id'];
            $order['user_id'] = auth()->user()->id;
            $order['method'] = 'elsaraf';

            $order->save();
            $order_id = $order->id;

            $carts = Session::get('cart');
            $products = [];
            $qty = [];
            foreach ($carts as $id => $item) {
                $qty[] = $item['qty'];
                $products[] = Product::findOrFail($id);
            }


            foreach ($products as $key => $product) {
                if (!empty($product->category)) {
                    $category = $product->category->name;
                } else {
                    $category = '';
                }
                OrderItem::insert([
                    'product_order_id' => $order_id,
                    'product_id' => $product->id,
                    'user_id' => Auth::user()->id,
                    'title' => $product->title,
                    'sku' => $product->sku,
                    'qty' => $qty[$key],
                    'category' => $category,
                    'price' => $product->current_price,
                    'previous_price' => $product->previous_price,
                    'image' => $product->feature_image,
                    'summary' => $product->summary,
                    'description' => $product->description,
                    'created_at' => Carbon::now()
                ]);
            }

            foreach ($cart as $id => $item) {
                $product = Product::findOrFail($id);
                $stock = $product->stock - $item['qty'];
                Product::where('id', $id)->update([
                    'stock' => $stock
                ]);
            }

            $fileName = str_random(4) . time() . '.pdf';
            $path = 'assets/front/invoices/product/' . $fileName;
            $data['order'] = $order;
            $pdf = PDF::loadView('pdf.product', $data)->save($path);


            ProductOrder::where('id', $order_id)->update([
                'invoice_number' => $fileName
            ]);

            // Send Mail to Buyer
            $mail = new PHPMailer(true);
            $user = Auth::user();

            if ($be->is_smtp == 1) {
                try {

                    $mail->isSMTP();
                    $mail->Host = $be->smtp_host;
                    $mail->SMTPAuth = true;
                    $mail->Username = $be->smtp_username;
                    $mail->Password = $be->smtp_password;
                    $mail->SMTPSecure = $be->encryption;
                    $mail->Port = $be->smtp_port;

                    //Recipients
                    $mail->setFrom($be->from_mail, $be->from_name);
                    $mail->addAddress($user->email, $user->fname);

                    // Attachments
                    $mail->addAttachment('assets/front/invoices/product/' . $fileName);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = "Order placed for Product";
                    $mail->Body = 'Hello <strong>' . $user->fname . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                    $mail->send();
                } catch (Exception $e) {
                    // die($e->getMessage());
                }
            } else {
                try {

                    //Recipients
                    $mail->setFrom($be->from_mail, $be->from_name);
                    $mail->addAddress($user->email, $user->fname);

                    // Attachments
                    $mail->addAttachment('assets/front/invoices/product/' . $fileName);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = "Order placed for Product";
                    $mail->Body = 'Hello <strong>' . $user->fname . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                    $mail->send();
                } catch (Exception $e) {
                    // die($e->getMessage());
                }
            }


            Session::forget('elsaraf_data');
            Session::forget('order_data');
            Session::forget('elsaraf_payment_id');
            Session::forget('cart');

            return redirect($success_url);

        }



    }
}
