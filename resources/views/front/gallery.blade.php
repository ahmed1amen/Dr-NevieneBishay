@extends("front.$version.layout")

@section('pagename')
 - {{__('Gallery')}}
@endsection

@section('meta-keywords', "$be->gallery_meta_keywords")
@section('meta-description', "$be->gallery_meta_description")
<style>
@-webkit-keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(calc(-250px * 7));
  }
}

@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(calc(-250px * 7));
  }
}
    .slider {
  background: white;

  height: 100%;
  margin: auto;
  overflow: hidden;
  position: relative;
  width: 96%;
}
.slider::before, .slider::after {
 
  content: "";
  height: 100px;
  position: absolute;
  width: 200px;
  z-index: 2;
}
.slider::after {
  right: 0;
  top: 0;
  transform: rotateZ(180deg);
}
.slider::before {
  left: 0;
  top: 0;
}
.slider .slide-track {
  -webkit-animation: scroll 40s linear infinite;
          animation: scroll 40s linear infinite;
  display: flex;
  width: calc(250px * 14);
}
.slider .slide {
  height: 100px;
  width: 250px;
}
</style>
@section('content')
<!--   breadcrumb area start   -->
<div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
   <div class="container">
      <div class="breadcrumb-txt">
         <div class="row">
            <div class="col-xl-7 col-lg-8 col-sm-10">
               <span>{{$bs->gallery_title}}</span>
               <h1>{{$bs->gallery_subtitle}}</h1>
               <ul class="breadcumb">
                  <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                  <li>{{__('GALLERY')}}</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
</div>
<!--   breadcrumb area end    -->


<!--    Gallery section start   -->
<div class="gallery-section masonry clearfix">
    <div class="container">
        <h2 class="text-center">{{__('auth.cases')}}</h2>
        <div class="slider">
	<div class="slide-track">
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-1.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-2.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-3.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-4.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-5.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-6.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-7.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-9.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-14.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-15.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-16.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-17.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-18.jpg" height="400" width="290" alt="" />
		</div>
		<div class="slide">
			<img src="https://dr-nevienebishay.com/website2/img/Protruding-Canines-19.jpg" height="400" width="290" alt="" />
		</div>
	</div>
</div>
    </div>
   <div class="container">
      <div class="grid">
         <div class="grid-sizer"></div>
         @foreach ($galleries as $key => $gallery)
           <div class="single-pic">
              <img src="{{asset('assets/front/img/gallery/'.$gallery->image)}}" alt="">
              <div class="single-pic-overlay"></div>
              <div class="txt-icon">
                 <div class="outer">
                    <div class="inner">
                       <h4>{{convertUtf8(strlen($gallery->title)) > 20 ? convertUtf8(substr($gallery->title, 0, 20)) . '...' : convertUtf8($gallery->title)}}</h4>
                       <a class="icon-wrapper" href="{{asset('assets/front/img/gallery/'.$gallery->image)}}" data-lightbox="single-pic" data-title="{{convertUtf8($gallery->title)}}">
                       <i class="fas fa-search-plus"></i>
                       </a>
                    </div>
                 </div>
              </div>
           </div>
         @endforeach
      </div>
      <div class="row mt-5">
         <div class="col-md-12">
            <nav class="pagination-nav">
              {{$galleries->links()}}
            </nav>
         </div>
      </div>
   </div>
   
</div>

<!--    Gallery section end   -->
@endsection
