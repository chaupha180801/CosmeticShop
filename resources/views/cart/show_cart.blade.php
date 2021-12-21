@extends('frontLayout')
@section('frontEndContent')
<div class="container">
    <div class="breadcums row">
        <ul>
            <li>Trang chủ</li>
            <li><i class="fa fa-angle-right"></i></li>
            <li>Giỏ hàng</li>
        </ul>
    </div>
    <div class="row cart">
        <div class="col-md-12">
            <div class="table_desc">
                <div class="cart_page table-responsive">
                <?php
                $content = Cart::content();
               
                ?>
             <table id="tbl_cart">
                
                <thead>
                    <tr>
                        <th class="product_thumb" >Hình ảnh</th>
                        <th class="product_name" >Tên sản phẩm</th>
                        <th class="product-price">Giá</th>
                        <th class="product_quantity">Số lượng</th>
                        <th class="product_total">Thành tiền</th>
                        <th class="product_remove">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $key => $v_content)
                    <tr>
                        <td class="product_thumb"><img src="{{asset('public/backEnd/images/'.$v_content->options->image)}}" height="100" width="100"></td>
                        <td class="product_name">{{$v_content->name}}</td>
                        <td class="product-price">{{number_format($v_content->price)}} VNĐ</td>
                        <input class="product-price-value" type="hidden" value={{$v_content->price}}>
                        <input class="product-row-id" type="hidden" value={{$v_content->rowId}}>
                        @foreach($sanpham as $sp)
                            @if($sp->product_id == $v_content->id)
                                <input class="product-id-quantity" type="hidden" value={{$sp->product_quanity}}>
                            @endif
                        @endforeach
                        
                        <td class="product-quantity-cell" > 
                            <button class="minus">-</button>  
                            <input class='product-quantity' type='text' min=1 value={{$v_content->qty}}> 
                            <button class="plus">+</button>              
                        </td> 
                        <td class="product-price">
                            <label class="product-total">{{number_format($v_content->price * $v_content->qty)}}</label> VNĐ</td>
                        <td class="product_remove"><a href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    @endforeach   
                    <tr>
                        <td colspan="2" align="left" style="text-align: left;">
                            <input type="text" id="discount-code" name="discount_id" placeholder="Nhập mã giảm giá">
                            <button id="apply-discount">Áp dụng</button>
                        </td>
                    </tr>
                </tbody>
               </table>   
                </div>  
                    <div class="cart_submit">
                </div>          
            </div>     
         </div>
        <div class="col-lg-12 col-md-12 ">
            <div class="sub_cart_wrap">
            <table id="tbl_subcart">
                <tr style="width: 500px;">
                <?php
                    $total = str_replace(',','',Cart::subtotal());
                    $total_cart = floatval($total);                                         
                ?>
                    <td  class="text-right"><p>Thành tiền:</p></td>
<<<<<<< HEAD
                    <td> <span id="total-product">{{Cart::subtotal()}}</span></td>
=======
                    <td> <span id="total-product">{{number_format($total_cart)}}</span></td>
>>>>>>> 1eaf81d75009390d248e5b71f5da95aabb452590
                    <td  id="vnd">&nbsp VNĐ</td>
                </tr>
                <tr>     
                    <td class="text-right">
                         <p>Số tiền giảm:</p>
                    </td>
                    <td>
                        <span id="cart-discount">0</span>
                    </td>
                    <td id="vnd">&nbsp VNĐ</td>
                </tr>
                <tr>
                    <td class="text-right">
                        <p>Tổng tiền hóa đơn:</p>
                    </td>
                    <td>
                    <?php
                        $total = str_replace(',','',Cart::subtotal());
                        $total_cart = floatval($total);                                         
                    ?>
                        <span id="cart-total">{{number_format($total_cart)}}</span>
                    </td>
                    <td  id="vnd">&nbsp VNĐ</td>
                </tr>
                <tr>
                    <td  class="text-right">
                        <a href="{{ url('/') }}" class="btn btn-warning">Tiếp tục mua sắm</a>
                  </td>
                  <td>
                        <?php
                           $account_id = Session::get('account_id');
                           if($account_id !=NULL){
                            ?>
                            <form action="{{URL::to('/checkout/'.$account_id)}}">
                                <input type="hidden" id="discount-id" name="discount_code" value="">
                                <button class="btn btn-success " id="choose-active">Thanh toán</button>
                                <input type="hidden" class="check-checkout" value={{Cart::content()->count()}}>
                           </form>
                            <?php
                           }else{
                               ?>
                                <a href="{{URL::to('/login-checkout')}}">
                                    <button class="btn btn-success" id="choose-active">Thanh toán</button>
                                    <input type="hidden" class="check-checkout" value={{Cart::content()->count()}}>
                                 </a>
                               <?php
                            }
                        ?>          
                    </td>

                </tr>
            </table>   
            </div>  
                <div class="cart_submit">
            </div>          
        </div>     
     </div>
</div>


<script>
    $(document).ready(function(){
        var count = $('.check-checkout').val();
        if(count == 0){
            var x = document.getElementById("choose-active");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }         
        }
    });
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
                if (now < Date.parse(data.discount_start) || now > Date.parse(data.discount_end) || data.discount_quantity == 0){
                    alert("Khuyến mãi đã hết hạn sử dụng");
                }else{
                    var cart_total = calc_cart_total();
                    var cart_discount = cart_total * data.discount_percent/100;
                    cart_total = cart_total * (1 - data.discount_percent/100);
                    $('#cart-total').text(cart_total.toLocaleString("en-GB"));
                    $('#cart-discount').text(cart_discount.toLocaleString("en-GB"));
                    $('#discount-id').val(code);
                }
            },
                    
            error:function(params) {
                alert('Không tồn tại mã khuyến mãi');
            }
        });
    });


    $('.minus').click(function(){
        var row = $(this).parent().parent();
        if(parseInt(row.find('.product-quantity').val()) != 1){
        var product_quantity = parseInt(row.find('.product-quantity').val()) - 1;
        row.find('.product-quantity').val(product_quantity);
        var quanity = parseInt($('.product-id-quantity').val());
        
        
        var product_price = parseInt(row.find(".product-price-value").val());
            if (product_price == '') {
                product_price = 0;
            }
        var product_total = product_price * product_quantity;
        var old_product_total = parseInt(row.find(".product-total").text().replaceAll(',', ''));
        var total = calc_cart_total() - old_product_total + product_total;   
        row.find(".product-total").text(product_total.toLocaleString("en-GB"));
        $('#cart-total').text(total.toLocaleString("en-GB"));
        $('#total-product').text(total.toLocaleString("en-GB"));

        $.ajax({
            url: "{{url('/update-cart-quantity')}}",
            method: "POST",
            data: {
                    rowId_cart: row.find(".product-row-id").val(),
                    qty_cart: product_quantity,
                    _token: "{{ csrf_token() }}"
                }
            }); 
        }
    });


    $('.plus').click(function(){
        var row = $(this).parent().parent();
        var product_quantity = parseInt(row.find('.product-quantity').val()) + 1;
        row.find('.product-quantity').val(product_quantity);
        var quanity = parseInt(row.find('.product-id-quantity').val());
        if(product_quantity > quanity){
            row.find('.product-quantity').val(product_quantity -1);
            alert("Số lượng sản phẩm chỉ còn " + quanity + " sản phẩm. Vui lòng giảm số lượng mua");
        }else{
            var product_price = parseInt(row.find(".product-price-value").val());
            if (product_price == '') {
                product_price = 0;
            }
            var product_total = product_price * product_quantity;
            var old_product_total = parseInt(row.find(".product-total").text().replaceAll(',', ''));
            var total = calc_cart_total() - old_product_total + product_total;
            row.find(".product-total").text(product_total.toLocaleString("en-GB"));
            $('#cart-total').text(total.toLocaleString("en-GB"));
            $('#total-product').text(total.toLocaleString("en-GB"));
            $('#cart-discount').text("0");
            $.ajax({
                url: "{{url('/update-cart-quantity')}}",
                method: "POST",
                data: {
                    rowId_cart: row.find(".product-row-id").val(),
                    qty_cart: product_quantity,
                    _token: "{{ csrf_token() }}"
                }
            });
        }
    });
</script>

@endsection