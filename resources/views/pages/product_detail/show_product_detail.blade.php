@extends('frontLayout')
@section('frontEndContent')
<style>
    .list_start i:hover{
       cursor: pointer;
   }
   .list_text{
       display: inline-block;
       margin-left: 10px;
       position: relative;
       background: #52b858;
       color: #fff;
       padding: 2px 8px;
       box-sizing: border-box;
       font-size: 12px;
       border-radius: 2px;
       display: none;
   }
   

   .list_text:after{
       right: 100%;
       top: 50%;
       border: solid transparent;
       content: " ";
       height: 0;
       width: 0;
       position: absolute;
       pointer-events: none;
       border-color: rgba(82,184,88,0);
       border-right-color: #52b858;
       border-width: 6px;
       margin-top: -6px;
   }
   .list_start .rating_active{
       color: #ff9705;
   }
   .hide{
    opacity: 0;
   }
</style>

<div class="row productDetail">
    @foreach($product_details as $key => $product)
             <br />
                <?php
                $message = Session::get('message');
                if ($message)
                {
                ?>
                    <div class="alert alert-success" role="alert">
                        Sản phẩm {{$product->product_name}} đã được thêm vào giỏi hàng.<a href="{{URL::to('/cart')}}">Xem giỏ hàng</a>
                    </div>
                <?php
                Session::put('message','');
                }
                ?>
    <div class="product_details">
        <div class="row">
                <div class="col-lg-4 col-md-5">
                    <ul id="imageGallery">
                        @foreach($gallery as $key => $gal)
                        <li data-thumb="{{asset('public/backEnd/images/'.$gal->gallery_img)}}" data-src="{{asset('public/backEnd/images/'.$gal->gallery_img)}}">
                            <img src="{{asset('public/backEnd/images/'.$gal->gallery_img)}}" width="100%" height="100%" alt="{{$gal->gallery_name}}">
                        </li>
                        @endforeach                                 
                    </ul>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="product_d_right">
                        <h1>{{$product->product_name}}</h1>
                         <div class="product_ratting mb-10">
                            <ul>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                        </div>
                        <div class="content_price mb-15">
                            <span> {{number_format($product->product_price).' VNĐ'}}</span>
                           
                        </div>
                        <div class="box_quantity mb-20">
                                
                            <form action="{{URL::to('/add-relative-to-cart')}}" method="POST">
                                {{ csrf_field() }}
                                 <label>Quantity</label>
                                <input min="1" max="100" value="1" type="number" name="qty_cart" >
                                <input type="hidden" name="productid_hidden" value="{{$product->product_id}}" />
                                <input type="hidden" name="product_cart_name" value="{{$product->product_name}}" />
                                <input type="hidden" name="product_cart_price" value="{{$product->product_price}}" />
                                <input type="hidden" name="product_cart_image" value="{{$product->product_img}}" />
                                <button type="submit"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</button>
                            </form> 
                            
                        </div>
                        <div class="product_stock mb-20">
                           <p>{{$product->product_quanity}} sản phẩm</p>
                            <span> Còn hàng </span>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    
    <!--product details end-->


    <!--product info start-->
    <div class="product_d_info">
        <div class="row">
            <div class="col-12">
                <div class="product_d_inner">   
                    <div class="product_info_button">    
                        <ul class="nav" role="tablist">
                          
                            <li>
                               <a  class="active"  data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Nhận xét</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Thông tin sản phẩm</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="reviews" role="tabpanel">
                       
                            <div class="component_rating" style="margin-bottom: 20px">
                                <h5>Đánh giá sản phẩm</h5>
                                <div class="component_rating_content" style="display: flex; align-items: center;border-radius: 5px;border:1px solid #dedede">
                                        <div class="rating_item" style="width: 20%;position: relative">
                                             <span class="fa fa-star" style="font-size: 100px;display: block;color: #ff9705;margin: 0 auto;text-align: center;"><b style="position: absolute;top: 50%;left: 50%;transform: translateX(-50%) translateY(-50%); color: white;font-size: 21px;">2.5</b></span>
                                        </div>
                                        <div class="list_rating" style="width: 60%; padding:20px">
                                        @for($i=1;$i<=5;$i++)
                                            <div class="item_rating" style="display:flex;align-items: center;">
                                                
                                                     <div style="width: 10%;font-size: 14px">
                                                         {{$i}}<span class="fa fa-star"></span>
                                                     </div >
                                                     <div style="width: 70%;margin: 0 20px">
                                                         <span style="width: 100%;height: 8px;display:block;border: 1px solid #dedede;border-radius: 5px;background-color:#dedede"><b style="width: 30%;background-color: #f25800;display: block;border-radius: 5px;height: 100%"></b></span>
                                                     </div>
                                                         
                                                     <div style="width: 20%">
                                                         <a  href="#"  style="color:black">290 đánh giá</a>
                                                     </div>              
                                            </div>
                                            @endfor
                                        </div>
                                     
                                 </div>
                                 <?php
                                     $listRatingText = [
                                         1 => 'Không thích',
                                         2 => 'Tạm được',
                                         3 => 'Bình thường',
                                         4 => 'Rất tốt',
                                         5 => 'Tuyệt vời',
                                     ];
                                 ?>
                                 <div class="form_rating active">
                                     <div style="display:flex;margin-top:15px;font-size:15px">
                                         <p style="margin-bottom:0">Chọn đánh giá của bạn</p>
                                         <span style="margin: 0 15px" class="list_start">
                                             @for($i = 1;$i<=5;$i++)
                                                 <i class="fa fa-star" data-key="{{$i}}"></i>
                                             @endfor
                                         </span>
                                         <span  class="list_text"></span>
                                     </div>
                                     <div style="margin-top: 10px">
                                         <textarea class="reviews_content" name="" id="form_control" cols="100" rowa="3" placeholder="Thêm nhận xét.." name="cmt_content"></textarea>
                                     </div>
                                     <div style="margin-top: 10px">
                                         <a href="#"  class="js_rating_product" style="width: 200px;background: #288ad6;padding: 5px;color: white;border-radius: 5px;">Gửi đánh giá</a>
                                     </div>
                                 </div>               
                             </div>
                         </div>
                         {{-- end comment --}}
                        <div class="tab-pane fade" id="info" role="tabpanel">
                            <div class="product_info_content">
                                <p>
                                    <b>Danh mục: </b>
                                    {{$product->category_name}}
                                </p>
                                <p>
                                    <b>Thương hiệu: </b>
                                    {{$product->brand_name}}
                                </p>
                                <p>
                                    <b>Nhà cung cấp: </b>
                                    {{$product->supplier_name}}
                                </p>
                                <p>
                                    <b>Mô tả: </b>
                                    {{$product->product_desc}}
                                </p>
                            </div>    
                        </div>
                   
                    </div>
                </div>     
            </div>
        </div>
    </div>  
    @endforeach
    <div class="related_product">
        <div class="row">

            <div class="col-sm-12">
                <h2 class="realted_product_name">Sản phẩm liên quan</h2>
            </div>
            @foreach($product_relative as $key => $result)
            <div class="col-sm-3 product_wrap">
           
                <div class="home-product-item">

                    <div class="product_image">
                        <img src="{{URL::to('public/backEnd/images/'.$result->product_img)}}" alt="">
                        <div class="overlay"></div>
                        <form action="{{URL::to('/add-relative-to-cart')}}" method="POST">
                           {{ csrf_field() }}
                                <input type="hidden" name="productid_hidden" value="{{$result->product_id}}" />
                                <input type="hidden" name="product_cart_name" value="{{$result->product_name}}" />
                                <input type="hidden" name="product_cart_price" value="{{$result->product_price}}" />
                                <input type="hidden" name="product_cart_image" value="{{$result->product_img}}" />
                                <input type="hidden" name="qty_cart" value="1" min="1"> 
                                <button type="submit" class="add_cart" ><i class="fas fa-cart-plus"></i>Add to cart</button> 
                            </form> 
                        <!-- <div class="add_cart"><i class="fas fa-cart-plus"></i>Add to cart</div> -->
                    </div>

                    <div class="product_content">
                        <h3 class="name">{{$result->product_name}}</h3>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </p>
                        <p class="price">
                            {{number_format($result->product_price).' VNĐ'}}
                        </p>
                        <div class="add_to">
                            <button>Add to wishlist</button>
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$result->product_id)}}">
                            <button>View detail</button>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            @endforeach
    </div>
    <div class="row">
            <div class="col l-12 m-12 c-12 pagination_wrap">
                <div class="pagination">
                    <li style="display:inline;{{ ($product_relative->currentPage() == 1) ? 'none;' : '' }}">
                        <a href="{{ $product_relative->url(1) }}">&laquo;</a>
                    </li>
                    @for ($i = 1; $i <= $product_relative->lastPage(); $i++)
                        <?php
                        $link_limit = 7;
                        $half_total_links = floor($link_limit / 2);
                        $from = $product_relative->currentPage() - $half_total_links;
                        $to = $product_relative->currentPage() + $half_total_links;
                        if ($product_relative->currentPage() < $half_total_links) {
                        $to += $half_total_links - $product_relative->currentPage();
                        }
                        if ($product_relative->lastPage() - $product_relative->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($product_relative->lastPage() - $product_relative->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li style="display:inline;" class="{{ ($product_relative->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $product_relative->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li style="display:inline;{{ ($product_relative->currentPage() == $product_relative->lastPage()) ? 'none;' : '' }}">
                        <a href="{{ $product_relative->url($product_relative->lastPage()) }}">&raquo;</a>
                    </li>
                </div>
            </div>
    </div>

</div>

 
@endsection

@section('script')
    <script>
        $(function(){
            let listStart = $(".list_start .fa");
            listRatingText = {
                    1: 'Không thích',
                    2: 'Tạm được',
                    3: 'Bình thường',
                    4: 'Rất tốt',
                    5: 'Tuyệt vời',
            }
            listStart.mouseover(function(){
                let $this = $(this);
                let number = $this.attr('data-key');
                listStart.removeClass('rating_active');
                $.each(listStart, function(key,value){
                    if(key + 1 <= number){
                        $(this).addClass('rating_active')
                    }
                });
                $(".list_text").text('').text(listRatingText[number]).show();
            });

           $(".js_rating_action").click(function(event){
                event.preventDefault();
                if($(".form_rating").hasClass('hide')){
                    $(".form_rating").addClass('active').removeClass('hide')
                }else{
                    $(".form_rating").addClass('hide').removeClass('active')
                }
            }) 

            $(".js_rating_product").click(function(e){
                e.preventDefault();
            });
        });
    </script>
@endsection