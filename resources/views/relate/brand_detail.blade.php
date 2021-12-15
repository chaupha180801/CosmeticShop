@extends('frontLayout')
@section('frontEndContent')
<div class="container-fluid">
    <div class="row slide">
        <div class="col-sm-12 main_slide">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('public/frontEnd/images/slide_1.png')}}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                          
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('public/frontEnd/images/slide_2.jpg')}}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                           
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('public/frontEnd/images/slide_3.jpg')}}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                    
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    
    </div>
</div>
<div class="container about_brand">
    <div class="row">
        <div class="brand_header">
            <h3>BEST SALER</h3>
        </div>
    </div>
    {{-- start row product --}}
    <div class="row">
        @foreach ($product as $key => $sp)
        <div class="col-sm-3 product_wrap">
               {{-- start product item --}}
                <div class="home-product-item">
                    <div class="product_image">                          
                        <img src="{{URL::to('public/backEnd/images/'.$sp->product_img)}}" alt="">
                        <img src="{{URL::to('public/frontEnd/images/hot.png')}}" id="hot_product" alt="">
                        <div class="overlay" ></div>                                                          
                        <form action="{{URL::to('/add-to-cart')}}" method="POST">
                        {{ csrf_field() }}
                                <input type="hidden" name="productid_hidden" value="{{$sp->product_id}}" />
                                <input type="hidden" name="product_cart_name" value="{{$sp->product_name}}" />
                                <input type="hidden" name="product_cart_price" value="{{$sp->product_price}}" />
                                <input type="hidden" name="product_cart_image" value="{{$sp->product_img}}" />
                                <input type="hidden" name="qty_cart" value="1" min="1"> 
                                <button type="submit" class="add_cart" ><i class="fas fa-cart-plus"></i>Thêm vào giỏ hàng</button> 
                         </form>                         
                    </div>
                    <div class="product_content">
                        <a href="{{URL::to('/chi-tiet-san-pham/'.$sp->product_id)}}">
                            <h3 class="name">{{$sp->product_name}}</h3>
                            <?php
                                $ageDetail = 0;
                                if($sp->product_total_comment){
                                    $ageDetail = round($sp->product_total_rating / $sp->product_total_comment,2);
                                }
                            ?>
                            <div class="rating">
                                @for($i = 1; $i<=5;$i++)
                                    <a href="#"><i class="fa fa-star {{$i <= $ageDetail ? 'active' : '' }}" style="color: #999"></i></a>
                                @endfor
                            </div>
                            <p class="price">
                             <span>{{number_format($sp->product_price)}} vnđ </span>  
                            </p>
                            <div class="add_to">
                                <a href="{{URL::to('/chi-tiet-san-pham/'.$sp->product_id)}}">
                                <button>Xem chi tiết</button>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- end product item --}}
        </div>
        @endforeach  
    </div>
     {{-- end row product --}}
    <div class="row">
        <div class="col-md-12 brand_header">
           <h3 class="about_br">ABOUT <SPAN></SPAN></h3>
        </div>
        <div class="col-md-3">
            <img src="{{asset('public/frontEnd/images/brand_detail2.jpg')}}" id="brand_img_1" alt="">
        </div>
        <div class="col-md-8 offset-md-1">
            <h4>Local Brand</h4>
            <p>
                 Favourite cosmetic items, but without the expensive burden that drains the fun out of any purchase! <br>
                
                Your first question might be, How are you able to do this? At Cosmetic Capital,
                 we use our unique relationships with cosmetic manufacturers, local distributors, overseas partners, clearance houses,
                  and retail stores, to source the best deals on cosmetics that are available. We literally search the globe for the best deals around. 
                  We have forged these relationships over many years. We don’t like to boast, but we are the experts in finding great deals. <br>
                
              </p>
        </div>
       
        
    </div>
   
  
   
</div>
<div class="container_fluid">
    <div class="row bg_img">

    </div>
</div>
<div class="container about_brand2">
    <div class="row">
    <div class="col-md-8">
        <h4>Afforble</h4>
        Cosmetic Capital offers free freight for any order over $60 to anywhere in Australia, no matter how large the order is, or how far away you may possibly live (Australia only). <br>

        For all orders under $60, there is a $7.95 Flat Rate for shipping. <br>
        
        We also offer $7.95 Express Shipping for orders over $60 of product value for anyone wanting their order even faster! For all orders under $60 of product value, it is $12.95 for Express Shipping. <br>
        
       <br>
    </div>
    <div class="col-md-4">
        <img src="{{asset('public/frontEnd/images/brand_detail1.jpg')}}" id="brand_img_2" alt="" width="200">
    </div>
</div>
</div>
@endsection