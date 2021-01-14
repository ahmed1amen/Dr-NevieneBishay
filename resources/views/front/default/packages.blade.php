@extends('front.default.layout')

@section('pagename')
 - {{__('Packages')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")

@section('content')
<!--   breadcrumb area start   -->
<div class="breadcrumb-area cases" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
   <div class="container">
      <div class="breadcrumb-txt">
         <div class="row">
            <div class="col-xl-7 col-lg-8 col-sm-10">
               <span>{{convertUtf8($be->pricing_title)}}</span>
               <h1>{{convertUtf8($be->pricing_subtitle)}}</h1>
               <ul class="breadcumb">
                  <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                  <li>{{__('Packages')}}</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
</div>
<!--   breadcrumb area end    -->


<!--    Packages section start   -->
<div class="pricing-tables pricing-page">
   <div class="container">
     <div class="row">
       @foreach ($packages as $key => $package)
         <div class="col-lg-3 col-md-6">
           <div class="single-pricing-table">
              <span class="title">{{convertUtf8($package->title)}}</span>
              <div class="price">
                 <h1>{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$package->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</h1>
              </div>
              <div class="features" style="height:150px;">
                 {!! replaceBaseUrl(convertUtf8($package->description)) !!}
              </div>

              @if ($package->order_status == 1)
              <a href="{{route('front.packageorder.index', $package->id)}}" class="pricing-btn">{{__('Place Order')}}</a>
              @endif
                 <br>
             <span class="text-center"><p class="text-center mt-4" style="font-size:12px">{{__('auth.validforone')}} <br> {{__('auth.terms')}}</p></span>
           
           </div>
         </div>
       @endforeach
     </div>
   </div>
</div>
 <div class="row mb-3 mt-3 text-center justify-content-center">
                    <div class="col-1 px-1 mb-1"><img src="https://elsaraf.com/ar/img/visa.jpg" class="img-fluid w-100"></div>
                    <div class="col-1 px-1 mb-1"><img src="https://elsaraf.com/ar/img/Mastercard.jpg" class="img-fluid w-100"></div>
                    <div class="col-1 px-1 mb-1"><img src="https://elsaraf.com/ar/img/paypal.jpg" class="img-fluid w-100"></div>
                    <div class="col-1 px-1 mb-1"><img src="https://elsaraf.com/ar/img/Meeza card.jpg" class="img-fluid w-100"></div>
                    <div class="col-1 px-1 mb-1"><img src="https://elsaraf.com/ar/img/Fawry.jpg" class="img-fluid w-100"></div></div>
       
<!--    Packages section end   -->
@endsection
