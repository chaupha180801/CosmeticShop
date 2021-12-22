@extends('frontLayout')
@section('frontEndContent')
<div class="container">
    <div class="breadcums row">
        <ul>
            <li> <a href="{{URL::to('/')}}"> Trang chủ</a></li>
            <li><i class="fa fa-angle-right"></i></li>
            <li>Thanh toán</li>
        </ul>
    </div>
    {{-- end row 1 --}}
    
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
                    <label for="country">Tỉnh/thành phố <span>*</span></label> <br>
                    <select name="shipping_district"  class="input_checkout_infomation choose city" id="city"> 
                        <option value="">Chọn tỉnh/thành phố</option> 
                        @foreach($city as $key => $item)
                            <option value="{{$item->matp}}">{{$item->name_city}}</option>
                         @endforeach     
                    </select>
                </div>
    
                <div class="col-4 mb-30">
                    <label for="country">Huyện/thành phố<span>*</span></label> <br>
                    <select name="shipping_province"  class="input_checkout_infomation province choose" id="province"> 
                        <option value="">Chọn huyện/thành phố</option> 
                    </select>     
                </div>
                <div class="col-4 mb-30">
                    <label for="country">Xã/phường<span>*</span></label> <br>
                    <select name="shipping_commune"  class="input_checkout_infomation wards" id="wards"> 
                        <option value="">Chọn xã/phường</option> 
                    </select>    
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
    {{-- end row 2 --}}
    <div>
        <form action="{{URL::to('/save-checkout-customer')}}" id="checkout_form" method="POST" class="row checkout">
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
                                        <p class="shipping_item_address"><i class="fas fa-map-marker-alt"></i> {{$item_shipping->shipping_address}} - {{$address[2]}} - {{$address[1]}} - {{$address[0]}}</p>
                                        <?php if ($i ==2) echo "<p class='default_shipping'>(Mặc định)</p>" ?>
                                  
                                       <a href="{{URL::to('/delete-shipping/'.$account_id)}}"> <i class="far fa-times-circle"></i></a>
                                
                                </div>
                            </div>
                        </label>
                        <br>
                        @endforeach
    
                        <div class="add_new_shipping" onclick="addShipping()">
                            <p>Thêm địa chỉ mới</p>
                            <i class="far fa-plus-square"></i>
                        </div>
                    
             </div>
             {{-- end cột bên trái --}}
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
                                        <td class="product_name" style="text-align: left; margin-left: 10px;">
                                          
                                             <span style="margin-left: 10px;">{{$v_content->name}}</span>  <strong> × {{$v_content->qty}}</strong></td>
                                        <td> {{number_format($v_content->price)}} VNĐ</td>
                                        <input class="product-price-value" type="hidden" value={{$v_content->price}}>
                                        <input class="product-row-id" type="hidden" value={{$v_content->rowId}}>
                                        <td>
                                            <label class="product-total">{{number_format($v_content->price * $v_content->qty)}}</label>
                                            VNĐ
                                        </td> 
                                    </tr>
                                    
                                    @endforeach   
                                {{-- </tbody> --}}
                                @if($discount)
                                <input type="hidden" name="discount" value="{{$discount->discount_id}}">
                                <input type="hidden" name="discount_quantity" value="{{$discount->discount_quantity}}">
                                {{-- <tfoot> --}}
                                    <tr>
                                        <td colspan="3">
                                            <div class="card_result">
                                                <table class="thai123">
                                                    <tr>
                                                        <?php
                                                        $total = str_replace(',','',Cart::subtotal());
                                                        $total_cart = floatval($total);                                         
                                                        ?>
                                                        <th style="text-align: left; width:250px;">Tổng tiền sản phẩm</th>
                                                        <td> {{number_format($total_cart)}} VNĐ</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left;">Mã giảm giá</th>
                                                        <td>                             
                                                            <strong>
                                                                {{$discount->discount_code}}
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>                           
                                                        <th style="text-align: left;">Phần trăm giảm giá</th>
                                                        <td><strong>{{$discount->discount_percent}}%</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                            $total = str_replace(',','',Cart::subtotal());
                                                            $total_cart = floatval($total);
                                                            $total_discount = $total_cart * $discount->discount_percent/100;
                                                        ?>
                                                        <th style="text-align: left;">Số tiền giảm</th>
                                                        <td><strong>{{number_format($total_discount)}} VNĐ</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left;">Tiền ship</th>
                                                        <td>                             
                                                            <strong>
                                                                30,000 VNĐ
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr class="order_total">
                                                        <th style="text-align: left;">Tổng tiền hóa đơn</th>
                                                        <td>
                                                            <?php
                                                                $total = str_replace(',','',Cart::subtotal());
                                                                $total_cart = floatval($total);
                                                                $total_discount = $total_cart *(1- $discount->discount_percent/100) + 30000;
                                                            ?>
                                                            <input type="hidden" name="cart_total" value={{$total_discount}}>
                                                            
                                                            <strong id="cart-total">{{number_format($total_discount)}}</strong>
                                                            <strong> VNĐ </strong>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                {{-- </tfoot> --}}
                                @else
                                <input type="hidden" name="discount" value=" ">
                                {{-- <tfoot> --}}
                                    <tr>
                                        <td colspan="3">
                                            <div class="card_result">
                                                <table class="thai123">
                                                    <tr>
                                                        <?php
                                                        $total = str_replace(',','',Cart::subtotal());
                                                        $total_cart = floatval($total);                                         
                                                        ?>
                                                        <th style="text-align: left;">Tổng tiền sản phẩm</th>
                                                        <td> {{number_format($total_cart)}} VNĐ</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left; width:250px;" >Tiền ship</th>
                                                        <td>                             
                                                            <strong>
                                                                30,000 VNĐ
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr class="order_total">
                                                        <th style="text-align: left;">Tổng tiền hóa đơn</th>
                                                        <td>
                                                            <?php
                                                                $total = str_replace(',','',Cart::subtotal());
                                                                $total_cart = floatval($total) + 30000;                                         
                                                            ?>
                                                            <input type="hidden" name="cart_total" value={{$total_cart}}>
                                                            <strong id="cart-total">{{number_format($total_cart)}}</strong>
                                                            <strong> VNĐ </strong>
                                                        </td>
                                                    </tr>
                                                </table>                                                           
                                            </div>
                                        </td> 
                                    </tr>
                                {{-- </tfoot> --}}
                                    {{-- end tfoot --}}
                                @endif    
                                <tr>
                                   
                                    <td  style="text-align: left; padding-left:10px;">
                                         <a class="btn btn-success"  href="{{URL::to('/cart')}}">
                                        Quay lại giỏ hàng
                                     </a></td>

                                     <td colspan="2" style="text-align: right; ">
                                        <button style="margin-right: 10px; padding: 5px 30px;" type="submit" class="btn btn-primary" onclick="checkoutFinal(event)">Đặt hàng</button>
                                    </td>
                                  
                                </tr>
                            </tbody>    
        
                        </table>
                    </div>
                    {{-- <div class="payment_method"> 
                            <button type="submit" class="btn btn-primary" onclick="checkoutFinal(event)">Đặt hàng</button>
                            <a class="btn btn-success"  href="{{URL::to('/cart')}}">
                               Quay lại giỏ hàng
                            </a>
                    </div>                  --}}
            </div>   
        </form> 
    </div>
    {{-- end row 3 --}}
        
</div>

   

    <script>
        $(document).ready(function(){ 
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var maid = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            if(action == 'city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url:'{{url('/address')}}',
                method:'POST',
                data:{action:action,maid:maid,_token:_token},
                success:function(data) {
                    $('#'+result).html(data);
                }
            });
        });
    });
    function addShipping(){
        new_shipping.style.display = "block";
    }
    function overlay_click(){
        new_shipping.style.display = "none";
    }

    function checkoutFinal(event){
        event.preventDefault();
        var shipping_item = document.getElementsByClassName("shipping_item");
        console.log(shipping_item);
        if(shipping_item.length > 0) {
            checkout_form.submit();
        }
        else {
         alert("Bạn chưa có địa chỉ giao hàng nào, vui lòng chọn địa chỉ giao hàng.");
         addShipping()
        }
    }
    </script>
 @endsection