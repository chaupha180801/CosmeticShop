@extends('frontLayout')
@section('frontEndContent')
<div class="breadcums row">
    <ul>
        <li>Home</li>
        <li><i class="fa fa-angle-right"></i></li>
        <li>Thanh toán</li>
    </ul>
</div>
<div class="row" id="new_shipping">
    <div class="overlay_shipping" onclick="overlay_click()">

    </div>
    <?php
    $account_id = Session::get('account_id');
    ?>
    <form class="row shipping_content" action="{{URL::to('/save-shipping/'.$account_id)}}" method="POST">
        {{ csrf_field() }}
        <h3>Thêm địa chỉ mới</h3>
            <div class="col-md-7 mb-30">
                <label>Tên người nhận</label>  <span>*</span></label> <br>
                <input class="input_checkout_infomation" type="text" name="shipping_name"> 
            </div>
            <div class="col-lg-5 mb-30">
                <label>Điện thoại<span>*</span></label> <br>
                <input class="input_checkout_infomation" type="text" name="shipping_phone"> 

            </div> 
             <div class="col-lg-12 mb-30">
                <label> Địa chỉ email   <span>*</span></label> <br>
                  <input class="input_checkout_infomation" type="text" name="shipping_email"> 

            </div> 
         
            <div class="col-4 mb-30">
                <label for="country">Chọn tỉnh thành <span>*</span></label> <br>
                <select name="shipping_district"  class="input_checkout_infomation"> 
                    <option value="Thành phố Hồ Chí Minh">Thành phố Hồ Chí Minh</option>      
                    <option value="Hà Nội">Hà Nội</option> 
                    <option value="Đà Nẵng">Đà Nẵng</option>    
                    <option value="Bìn Định">Bìn Định</option>    
                    <option value="Quãng Ngãi">Quãng Ngãi</option>  

                </select>
            </div>

            <div class="col-4 mb-30">
                <label>Huyện/Thành phố  <span>*</span></label> <br>
                <input class="input_checkout_infomation" type="text" name="shipping_province">     
            </div>
            <div class="col-4 mb-30">
                <label>Xã/ phường <span>*</span></label> <br>
                <input class="input_checkout_infomation" type="text" name="shipping_commune">    
            </div> 
             <div class="col-12">
                <label>Địa chỉ nhà <span>*</span></label> <br>
                <input class="input_checkout_infomation" type="text" name="shipping_address">    
            </div> 
          
            <div class="col-12">
                <div class="order-notes">
                     <label for="order_note">Order Notes</label> <br>
                    <textarea id="order_note" placeholder="Ghi chú về giao hàng" class="input_checkout_infomation" rows="5" name="shipping_note"></textarea>
                </div>    
            </div>     	
            <button type="submit">Lưu</button>    	    	    	    	    	    
      
        
        </form>
  
</div>

<form action="{{URL::to('/save-checkout-customer')}}" method="POST" class="row checkout">
            {{ csrf_field() }}
    <div class="col-lg-6 col-md-6">
    
            <h3 class="checkout_heading">Thông tin nhận hàng</h3>
          <?php
              $i = 1;
          ?>
                @foreach ($shipping_list as $key_shipping => $item_shipping)
                <?php
                   $i++;
                ?>
                <input type="radio" name="shipping_selected" id="{{$i}}" class="radio_shipping" value="{{$item_shipping->shipping_id}}" <?php if ($i ==2) echo "checked='checked'" ?>> 
                <label for="{{$i}}" class="lb_radio">
                    <div class="row">
                        <div class="shipping_item">
                            <p class="shipping_item_name">{{$item_shipping->shipping_name}}</p>
                            <p class="shipping_item_phone"><i class="fas fa-phone"></i> (+84){{$item_shipping->shipping_phone}}</p>
                            <p class="shipping_item_address"><i class="fas fa-map-marker-alt"></i> {{$item_shipping->shipping_district}}</p>
                            <?php if ($i ==2) echo "<p class='default_shipping'>(Mặc định)</p>" ?>
                        </div>
                    </div>
                </label>
                <br>
                @endforeach
              
          
         
          <div class="row">
              <div class="add_new_shipping" onclick="addShipping()">
                  <p>Thêm địa chỉ mới</p>
                  <i class="far fa-plus-square"></i>
              </div>
          </div>
      
    </div>
    <div class="col-lg-6 col-md-6">
            <h3 class="checkout_heading">Chi tiết đơn hàng</h3> 
            <div class="order_table table-responsive mb-30">
            <?php
            $content = Cart::content();
            ?>
               <table class="table_prd_checkout">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm x số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($content as $v_content)
                        <tr>
                            <td class="product_name"> {{$v_content->name}} <strong> × {{$v_content->qty}}</strong></td>
                            <td> {{number_format($v_content->price). ' VNĐ'}}</td>
                            <td> <?php
                                $subtotal = $v_content->price * $v_content->qty;
                                echo number_format($subtotal).' VNĐ';
                                ?>
                            </td>
                        </tr>
                        
                        @endforeach   
                    </tbody>
                    <tfoot>
                        
                        <tr>
                            <th colspan="2">Tổng tiền sản phẩm</th>
                            <td> {{Cart::subtotal().' VNĐ'}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Tiền ship</th>
                            <td><strong>30.000đ</strong></td>
                        </tr>
                        <tr class="order_total">
                            <th colspan="2">Tổng tiền hóa đơn</th>
                            <td><strong>{{Cart::subtotal().' VNĐ'}}</strong></td>
                        </tr>
                    </tfoot>
                </table>
                
            </div>
            <!-- <form action="{{URL::to('/order-place')}}"  method="POST">
            {{ csrf_field() }} -->
            <div class="payment_method">
                    <p>Chọn hình thức thanh toán</p>
                    <input id="payment" name="check_method" type="radio" data-target="createp_account" value="1">
                    <label for="payment" data-toggle="collapse" data-target="#method" aria-controls="method">Thanh toán khi nhận hàng</label>
                     <br>
                    <input id="payment_defult" name="check_method" type="radio" data-target="createp_account" value="2">
                    <label for="payment_defult" data-toggle="collapse" data-target="#collapsedefult" aria-controls="collapsedefult">Thanh toán bằng thẻ <img src="assets\img\visha\papyel.png" alt=""></label>
                    <div class="col-md-12">
                     
                    <button class="btn btn-primary">Đặt hàng</button>

                    </div>
                   
            </div> 
                  
    </div>
    </form>
    
    <a href="{{URL::to('/cart')}}">
        <button class="btn btn-success">Quay lại giỏ hàng</button>
    </a>

<script >
    function addShipping(){
        new_shipping.style.display = "block";
    }

    function overlay_click(){
        new_shipping.style.display = "none";
    }
</script>
 @endsection