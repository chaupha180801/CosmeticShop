@extends('frontLayout')
@section('frontEndContent')
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
                            <td> {{number_format($v_content->price)}} VNĐ</td>
                            <input class="product-price-value" type="hidden" value={{$v_content->price}}>
                            <input class="product-row-id" type="hidden" value={{$v_content->rowId}}>
                            <td>
                                <label class="product-total">{{number_format($v_content->price * $v_content->qty)}}</label>
                                 VNĐ
                            </td> 
                        </tr>
                        
                        @endforeach   
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <input type="text" id="discount-code" name="discount_id" value="">
                            <button id="apply-discount">Áp dụng</button>
                        </td>
                    </tr>
                        <tr>
                            <th colspan="2">Tổng tiền sản phẩm</th>
                            <td> {{Cart::subtotal().' VNĐ'}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Tiền giảm</th>
                            <td><strong>30.000đ</strong></td>
                        </tr>
                        <tr class="order_total">
                            <th colspan="2">Tổng tiền hóa đơn</th>
                            <td>
                                <strong>Thành tiền: </strong>
                                <strong id="cart-total">{{Cart::subtotal()}}</strong>
                                <strong> VNĐ </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                
            </div>
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

<script>
      function calc_cart_total() {
        var sum = 0;
        var all_prices = $('.product-total');
        for(var i = 0; i < all_prices.length; i++)
        {
            sum += parseInt(all_prices[i].innerText.replaceAll(',', ''));
        }
        return sum;
    }

    $('#apply-discount').click(function(){
        var code = $('#discount-code').val();  
        $.ajax({
            url:"{{url('/discount/')}}" +'/' + code,
            method: "GET",
            success:function(data){
                var now = new Date();
                now = now.getTime();
                if (now < Date.parse(data.discount_start) || now > Date.parse(data.discount_end)){
                    alert("Khuyến mãi đã hết hạn sử dụng");
                }else{
                    var cart_total = calc_cart_total();
                    cart_total = cart_total * (1 - data.discount_percent/100);
                    $('#cart-total').text(cart_total.toLocaleString());
                }
            },                  
            error:function(params) {
                alert('Không tồn tại mã khuyến mãi');
            }
        });
    });
</script>
@endsection