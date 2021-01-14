<!DOCTYPE html>
<html lang="en">
   <head>
      <!--Start of Google Analytics script-->
      @if ($bs->is_analytics == 1)
      {!! $bs->google_analytics_script !!}
      @endif
      <!--End of Google Analytics script-->

      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <meta name="description" content="@yield('meta-description')">
      <meta name="keywords" content="@yield('meta-keywords')">

      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{$bs->website_title}} @yield('pagename')</title>
      <!-- favicon -->
      <link rel="shortcut icon" href="{{asset('assets/front/img/'.$bs->favicon)}}" type="image/x-icon">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
      <!-- plugin css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/plugin.min.css')}}">
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="102505031676610"
  theme_color="#7C6936">
      </div>
      @yield('styles')
      <!-- main css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">

      @if ($bs->is_tawkto == 1)
      <style>
      .back-to-top {
          bottom: 50px;
      }
      .back-to-top.show {
          right: 20px;
      }
      </style>
      @endif
      @if (count($langs) == 0)
      <style media="screen">
      .support-bar-area ul.social-links li:last-child {
          margin-right: 0px;
      }
      .support-bar-area ul.social-links::after {
          display: none;
      }
      </style>
      @endif
      @if($bs->feature_section == 0)
      <style media="screen">
      .hero-txt {
          padding-bottom: 160px;
      }
      </style>
      @endif
     <style>
     #teethwallet{
         width:50%;
     }
     @media only screen and (max-width: 600px) {
     body{
         overflow-x:hidden;
     }
      #teethwallet{
         width:80%;
     }
     .hidemobile{
         display:none;
     }
     .spacemobile{
         margin-top:30px;
     }
}
         .dc-fthreecolumns {
    float: left;
    width: 100%;
    padding: 30px 0 60px;
    height:350px;
}
.dc-fsocialicon {
    float: left;
    width: 100%;
}
.dc-fsocialicon .dc-simplesocialicons {
    margin: 0;
    font-size: 18px;
}
.dc-simplesocialicons {
    margin-bottom: 0;
    font-size: 16px;
    overflow: hidden;
    list-style: none;
    line-height: 20px;
    text-align: center;
}
     </style>
      <!-- responsive css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">
      <!-- base color change -->
      <link href="{{url('/')}}/assets/front/css/base-color.php?color={{$bs->base_color}}{{!isDark($be->theme_version) ? "&color1=" . $bs->secondary_base_color : ""}}" rel="stylesheet">

      @if (isDark($be->theme_version))
        <!-- dark version css -->
        <link rel="stylesheet" href="{{asset('assets/front/css/dark.css')}}">
        <!-- dark version base color change -->
        <link href="{{url('/')}}/assets/front/css/dark-base-color.php?color={{$bs->base_color}}" rel="stylesheet">
      @endif

      @if ($rtl == 1)
      <!-- RTL css -->
      <link rel="stylesheet" href="{{asset('assets/front/css/rtl.css')}}">
      @endif
      <!-- jquery js -->
      <script src="{{asset('assets/front/js/jquery-3.3.1.min.js')}}"></script>

      @if ($bs->is_appzi == 1)
      <!-- Start of Appzi Feedback Script -->
      <script async src="https://app.appzi.io/bootstrap/bundle.js?token={{$bs->appzi_token}}"></script>
      <!-- End of Appzi Feedback Script -->
      @endif

      <!-- Start of Facebook Pixel Code -->
      @if ($be->is_facebook_pexel == 1)
        {!! $be->facebook_pexel_script !!}
      @endif
      <!-- End of Facebook Pixel Code -->

      <!--Start of Appzi script-->
      @if ($bs->is_appzi == 1)
      {!! $bs->appzi_script !!}
      @endif
      <!--End of Appzi script-->
   </head>



   <body @if($rtl == 1) dir="rtl" @endif>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v9.0&appId=2521266241519851&autoLogAppEvents=1" nonce="Xd6eDcDZ"></script>
      <!--   header area start   -->
      <div class="header-area header-absolute @yield('no-breadcrumb')" >
         <div class=""><!--container !-->
            <div class="support-bar-area" style="background:#f7f7f7!important;">
               <div class="row">
                   <div class="col-lg-1"></div>
                  <div class="col-lg-2 text-center support-contact-info">
                     <span class="address m-0" style="color:black!important;">{{__('auth.helpyou')}}</span><br>
                     <span class="phone m-0 justify-content-center row " style="color:black!important;font-weight: 700;
    font-size: 20px;
    line-height: inherit;
    direction:ltr;
    ">+2001225377773</span>
                  </div>
                  
                  <div class="col-lg-8 {{$rtl == 1 ? 'text-left' : 'text-right'}}" style="display: flex;
    align-items: center;
    justify-content: flex-end;">
                     <ul class="social-links" style="
    padding: 11px 0;
    
    margin-bottom: 0;
    font-size: 16px;
    overflow: hidden;
    list-style: none;
    line-height: 20px;
    text-align: center;">
                      
                         <li><a target="_blank" href="#"><i class="fab fa-facebook-f iconpicker-component" style="color:#3b5999"></i></a></li>
                      
                        <li><a target="_blank" href="#"><i class="fab fa-twitter iconpicker-component"style="color:#55acee"></i></a></li>
                        <li><a target="_blank" href="#"><i class="fab fa-linkedin-in iconpicker-component" style="color:#0077B5"></i></a></li>
                      
                        <li><a target="_blank" href="#"><i class="fab fa-youtube iconpicker-component" style="color:#cd201f"></i></a></li>
                     </ul>

                     @if (!empty($currentLang))
                       <div class="language">
                          <a class="language-btn" style="color:black;" href="#"><i class="flaticon-worldwide"></i> {{convertUtf8($currentLang->name)}}</a>
                          <ul class="language-dropdown">
                            @foreach ($langs as $key => $lang)
                            <li><a href='{{ route('changeLanguage', $lang->code) }}'>{{convertUtf8($lang->name)}}</a></li>
                            @endforeach
                          </ul>
                       </div>
                     @endif

                     @guest
                     <!--<ul class="login">-->
                     <!--    <li><a href="{{route('user.login')}}">{{__('Login')}}</a></li>-->
                     <!--</ul>-->
                     @endguest
                     @auth
                     <!--<ul class="login">-->
                     <!--    <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>-->
                     <!--</ul>-->
                     @endauth


                  </div>
                  <div class="col-lg-1"></div>
               </div>
            </div>


            @includeIf('front.default.partials.navbar')

         </div>
      </div>
      <!--   header area end   -->


      @yield('content')


      <!--    announcement banner section start   -->
      <a class="announcement-banner" href="{{asset('assets/front/img/'.$bs->announcement)}}"></a>
      <!--    announcement banner section end   -->


      <!--    footer section start   -->
      <footer class="footer-section" style="direction:ltr;">
         <footer id="dc-footer" class="dc-footer dc-haslayout">
                                   
                            <div class="dc-fthreecolumns">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 float-left">
                        <div class="dc-fcol dc-widgetcontactus">
                            <!--<strong class="dc-logofooter"><a href="https://smileboutiqueclinics.com"><img src="https://smileboutiqueclinics.com/12-new1.png" alt="Site Logo"></a></strong>-->
                            <div class="dc-footercontent">
                                <div class="dc-ftitle"><h4><u>{{__('auth.information')}}</u></h4></div>
                                                                    <ul class="dc-footercontactus">
                                        <li><address><i class="fas fa-location-arrow"></i>6 Gameat Dewal Arabia Mohandessin , Giza <br>Beside Nabila Hotel</address></li>
                                        <li><address><i class="fas fa-location-arrow"></i>2 Bahgat Ali ,Tower C Abrag Masry , Zamlek <br>in front of Beit Ezz Restaurant</address></li>
                                        <li><a  href="mailto:info@smileboutiqueclinics.com"><i style="color:white!important" class="fas fa-envelope"></i> info@smileboutiqueclinics.com</a></li>
                                       
                                    </ul>
                                
                                                                    <div class="dc-fsocialicon ">
                                        <ul class="dc-simplesocialicons row ">
                                            <li class="dc-facebook mr-3 mt-2" ><a style="color:white!important;" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li class="dc-twitter mr-3 mt-2" ><a style="color:white!important;" href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li class="dc-linkedin mr-3 mt-2" ><a style="color:white!important;" href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                            <li class="dc-youtube mr-3 mt-2" ><a style="color:white!important;" href="#"><i class="fab fa-youtube"></i></a></li>
                                            </ul>
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 float-left">
                        <div class="tg-widgettwitter dc-fcol dc-flatestad dc-twitter-live-wgdets">
                            <div class="dc-ftitle spacemobile"><h4><u>Facebook Live Feed</u></h4></div>				
                            <div class="dc-footercontent">
                               <div class="fb-page" data-href="https://www.facebook.com/Smileboutiqueclinics" data-tabs="timeline" data-width="500" data-height="250" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Smileboutiqueclinics" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Smileboutiqueclinics">Smile Boutique Clinics</a></blockquote></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 float-left">
                        <div class="tg-widgettwitter dc-fcol dc-flatestad dc-twitter-live-wgdets">
                            <div class="dc-ftitle"><h4><u>{{__('auth.downloadnow')}}</u></h4></div>				
                            <div class="dc-footercontent">
                                <div class="site-footer__bottom__download mt-2">
                            <a href="#"><img src="https://stickyposts.net/sticky/images/APPSTORE.png" width="46%"></a>
                            <a href="#"><img src="https://stickyposts.net/sticky/images/Google play.png" class="" width="51%"></a>
                            
                            
                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 float-left">
                        <div class="dc-fcol dc-newsletterholder">
                            <div class="dc-footercontent dc-newsletterholder">
                                                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dc-footerbottom ">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 text-center">
                        <p class="dc-copyright hidemobile">Copyrights © 2020 by idigitaldevelopment.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
      </footer>
      <!--    footer section end   -->


      <!-- preloader section start -->
      <div class="loader-container">
         <span class="loader">
         <span class="loader-inner"></span>
         </span>
      </div>
      <!-- preloader section end -->


      <!-- back to top area start -->
      <div class="back-to-top">
         <i class="fas fa-chevron-up"></i>
      </div>
      <!-- back to top area end -->


      {{-- Cookie alert dialog start --}}
      @if ($be->cookie_alert_status == 1)
      @include('cookieConsent::index')
      @endif
      {{-- Cookie alert dialog end --}}

      @php
        $mainbs = [];
        $mainbs['is_announcement'] = $bs->is_announcement;
        $mainbs['announcement_delay'] = $bs->announcement_delay;
        $mainbs = json_encode($mainbs);
      @endphp
      <script>
        var lat = {{$bs->latitude}};
        var lng = {{$bs->longitude}};
        var mainbs = {!! $mainbs !!};

        var rtl = {{ $rtl }};
      </script>
      <!-- popper js -->
      <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
      <!-- bootstrap js -->
      <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
      <!-- Plugin js -->
      <script src="{{asset('assets/front/js/plugin.min.js')}}"></script>
      @if (request()->path() == 'contact')
      <!-- google map api -->
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7eALQrRUekFNQX71IBNkxUXcz-ALS-MY&callback=initMap" async defer></script>
      <!-- google map activate js -->
      <script src="{{asset('assets/front/js/google-map-activate.min.js')}}"></script>
      @endif
      <!-- main js -->
      <script src="{{asset('assets/front/js/main.js')}}"></script>

      @yield('scripts')

      @if (session()->has('success'))
      <script>
         toastr["success"]("{{__(session('success'))}}");
      </script>
      @endif

      @if (session()->has('error'))
      <script>
         toastr["error"]("{{__(session('error'))}}");
      </script>
      @endif

      <!--Start of subscribe functionality-->
      <script>
        $(document).ready(function() {
          $("#subscribeForm, #footerSubscribeForm").on('submit', function(e) {
            // console.log($(this).attr('id'));

            e.preventDefault();

            let formId = $(this).attr('id');
            let fd = new FormData(document.getElementById(formId));
            let $this = $(this);

            $.ajax({
              url: $(this).attr('action'),
              type: $(this).attr('method'),
              data: fd,
              contentType: false,
              processData: false,
              success: function(data) {
                // console.log(data);
                if ((data.errors)) {
                  $this.find(".err-email").html(data.errors.email[0]);
                } else {
                  toastr["success"]("You are subscribed successfully!");
                  $this.trigger('reset');
                  $this.find(".err-email").html('');
                }
              }
            });
          });
        });
      </script>
      <!--End of subscribe functionality-->

      <!--Start of Tawk.to script-->
      @if ($bs->is_tawkto == 1)
      {!! $bs->tawk_to_script !!}
      @endif
      <!--End of Tawk.to script-->

      <!--Start of AddThis script-->
      @if ($bs->is_addthis == 1)
      {!! $bs->addthis_script !!}
      @endif
      <!--End of AddThis script-->
   </body>
</html>
