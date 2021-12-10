<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/style.css?version=1')}}">
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/cartHeader.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/cart.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/product_detail.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/ightslider.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/lightgallery.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/prettify.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('public/frontEnd/css/cart_ajax.css')}}"> -->
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/checkout.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/comment.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript">
        $(document).ready(function(){
            $('#sort').on('change', function(){
                $('#form-sort').submit();
                return false;    
            });
        });

    </script>
</head>

<body>
    <div class="container wrap">
        <!-- ========================================================================start header =================================================
        header include: logo and searchbox , navigaton, breadcums -->
        <!-- logo and search box -->
        
        <div class="row header_search">
            <div class="image">
                <img src="{{asset('public/frontEnd/images/logo.png')}}" alt="">
            </div>
            
            <div class="search_box">

                <form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method ="GET">
                    {{ csrf_field() }}
                <input type="text" id="keywords" placeholder="Tìm kiếm..." name="tukhoa">
                <div id="search-ajax"></div>
                <button type="submit" name="search-items" value="Tìm kiếm"><i class="fa fa-search"></i></button>
                
                </form>
                <?php
                   $account_id = Session::get('account_id');
                   if($account_id !=NULL){
                    ?>
                    <a href="{{URL::to('/logout-checkout')}}">Đăng xuất</a>
                    <a href="{{URL::to('/purchase-history')}}">Lịch sử mua hàng</a>
                    <?php
                   }else{
                       ?>
                        <a href="{{URL::to('/login-checkout')}}">Đăng nhập/</a>
                        <a href="{{URL::to('/register-form')}}">Đăng kí</a>
                       <?php
                   }
                   ?>

            </div>
            <div class="header_cart">
                <a href="{{URL::to('/cart')}}" class="">
                    <i class="fas fa-shopping-cart"></i>
                    <p class="cart_quanity_header">{{Cart::content()->count()}}</p>
                </a>
            </div>
        </div>
        <!-- end logo and search box -->

        <!-- start navigation -->
        <div class="row navigation">
            <div class="logo_phone">
                <img src="{{asset('public/frontEnd/images/logo_notext1.png')}}" alt="">
            </div>
            <i class="fas fa-bars menu_icon"></i>
            <h3 class="menu_text">MENU</h3>
            <div class="search-box-phone" id="serch_phone">
                <input type="text" placeholder="Search..." class="search-txt-phone" id="input_phone">
                <button class="btn" id="search_icon_phone">
                    <i class="fas fa-search"></i>
                </button>

            </div>
            <ul class="list">
                <li class="item active">
                    <a href="" class="item_link">
                        Sản phẩm
                    </a>
                </li>
                <li class="item">
                    <a href="" class="item_link">
                        Thương hiệu <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="sub_list">
                        <ul>
                            @foreach($brand as $key => $thieu)
                                <li><a href="">{{$thieu->brand_name}}</a> </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="item">
                    <a href="" class="item_link">
                        Nhà cung cấp <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="sub_list">
                        <ul>
                        @foreach($supplier as $key => $ncc)
                            <li><a href="">{{$ncc->supplier_name}}</a> </li>
                        @endforeach
                        </ul>
                </li>
                <li class="item">
                    <a href="" class="item_link">
                        Dịch vụ
                    </a>
                </li>
                <li class="item">
                    <a href="" class="item_link">
                        Hàng mới về
                    </a>
                </li>
            </ul>
         
        </div>
        <!-- end navigation -->

        <!-- start breadcums -->
        <div class="breadcums row">
            <ul>
                <li>Home</li>
                <li><i class="fa fa-angle-right"></i></li>
                <li>Sản phẩm</li>
            </ul>
        </div>
        <!-- end breadcums -->
        <!-- =====================================================================end header===================================================================== -->
        <!-- =====================================================================start content =================================================================-->
        

        @yield('frontEndContent')
   
    </div>

    <!--=========================================================================================== end content======================================================== -->
    <!--=========================================================================================== start footer======================================================== -->
    <div class="container-fluid footer">
        <div class="container footer_content">
            <div class="row">
                <div class="col-sm-3 about_us">
                    <h4>ABOUT US</h4>
                    <ul>
                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                        <li><i class="fas fa-map-marker"></i>343 Lê Văn Việt Quận 9, tp.HCM</li>
                        <li><i class="fas fa-envelope-square"></i>giathai1505@gmail.com</li>
                        <li><i class="fas fa-phone"></i>0123456789</li>
                    </ul>
                </div>
                <div class="col-sm-3 my_account">
                    <h4>MY ACCOUNT</h4>
                    <ul>
                        <li>
                            <i class="fas fa-angle-right"></i> Your account
                        </li>
                        <li><i class="fas fa-angle-right"></i>My orders</li>
                        <li><i class="fas fa-angle-right"></i>My address</li>
                        <li><i class="fas fa-angle-right"></i>Login</li>
                        <li><i class="fas fa-angle-right"></i>My credict Slips</li>
                    </ul>
                </div>
                <div class="col-sm-3 contact">
                    <h4>INFOMATION</h4>
                    <ul>
                        <li>Special</li>
                        <li>Our Store</li>
                        <li>About us</li>
                        <li>Term and condition</li>
                        <li>Rules</li>
                    </ul>
                </div>
                <div class="col-sm-3 extra">
                    <h4>EXTRAS</h4>
                    <ul>
                        <li>Brands</li>
                        <li>Vocher</li>
                        <li>Discount</li>
                        <li>Privacy policy</li>
                        <li>Affilates</li>
                    </ul>
                </div>
            </div>
            <div class="row end">
                <div class="copy">
                    <h6>ABOUT US CUSTOMER SERVIC PRICACY POLICY</h6>
                    <P>Copyright © 2018 <strong style="color: black;">Pos Coron</strong> . All rights reserved.</P>
                </div>
                <div class="icon">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-instagram-square"></i>
                    <i class="fab fa-google-plus"></i>
                    <i class="fab fa-linkedin"></i>
                    <i class="fab fa-youtube-square"></i>
                </div>
            </div>
        </div>
    </div>
    <!--=========================================================================================== end footer======================================================== -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="./js/javascript.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{asset('public/frontEnd/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('public/frontEnd/js/lightslider.js')}}"></script>
    <script src="{{asset('public/frontEnd/js/prettify.js')}}"></script>


    <script type="text/javascript">
        
    $(document).ready(function() {
        $('#imageGallery').lightSlider({
            gallery:true,
            item:1,
            loop:true,
            thumbItem:3,
            slideMargin:0,
            enableDrag: false,
            currentPagerPosition:'left',
            onSliderLoad: function(el) {
                el.lightGallery({
                    selector: '#imageGallery .lslide'
                });
            }  
        });  
    });
    </script>

    <script type="text/javascript">
        $('#keywords').keyup(function(){
            var keywords = $(this).val();
            
            if(keywords != ''){                
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{url('/timkiem-ajax')}}",
                    method: "POST",
                    data:{keywords:keywords, _token:_token},
                    success:function(data){
                        $('#search-ajax').fadeIn();
                        $('#search-ajax').html(data);
                    }
                });
            }else{
                $('#search-ajax').fadeOut();
            }            
        });

        $(document).on('click', '.li_search_ajax', function(){
            $('#keywords').val($(this).text());
            $('#search-ajax').fadeOut();
        }); 
    </script>

@yield('script')  

</body>

</html>