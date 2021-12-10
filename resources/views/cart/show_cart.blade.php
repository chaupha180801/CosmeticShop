@extends('frontLayout')
@section('frontEndContent')
<div class="breadcums row">
    <ul>
        <li>Home</li>
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
            <table>
            
            <thead>
                <tr>
                    
                    <th class="product_thumb">Hình ảnh</th>
                    <th class="product_name">Tên sản phẩm</th>
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
                    <td>
                        <label class="product-total">{{number_format($v_content->price * $v_content->qty)}}</label> VNĐ</td>
                    <td class="product_remove"><a href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fas fa-trash"></i></a></td>
                </tr>
                @endforeach   
            </tbody>
        </table>   
            </div>  
                <div class="cart_submit">
            </div>          
        </div>     
     </div>
    <div class="col-lg-6 col-md-6">
        <tfoot>
        <tr>
            <td>
                <input type="text" id="discount-code" name="discount_id">
                <button id="apply-discount">Áp dụng</button>
            </td>
        </tr>
        <tr>     
            <td colspan="5" class="text-right"><h3>
                <strong>Số tiền giảm: </strong>
                <strong id="cart-discount">0</strong>
                <strong> VNĐ </strong>
            </h3></td>
        </tr>
        <tr>     
            <td colspan="5" class="text-right"><h3>
                <strong>Thành tiền: </strong>
                <strong id="cart-total">{{Cart::subtotal()}}</strong>
                <strong> VNĐ </strong>
            </h3></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>Tiếp tục mua sắm</a>
                <?php
                   $account_id = Session::get('account_id');
                   if($account_id !=NULL){
                    ?>
                    <form action="{{URL::to('/checkout/'.$account_id)}}">
                        <input type="hidden" id="discount-id" name="discount_code" value="">
                        <button class="btn btn-success">Thanh toán</button>
                   </form>
                    <?php
                   }else{
                       ?>
                        <a href="{{URL::to('/login-checkout')}}">
                            <button class="btn btn-success">Thanh toán</button>
                         </a>
                       <?php
                    }
                ?>          
            </td>
        </tr>
        </tfoot>
        <div>
        </div>
    </div>
    
</div>

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
                if (now < Date.parse(data.discount_start) || now > Date.parse(data.discount_end) || data.discount_quantity == 0){
                    alert("Khuyến mãi đã hết hạn sử dụng");
                }else{
                    var cart_total = calc_cart_total();
                    var cart_discount = cart_total * data.discount_percent/100;
                    cart_total = cart_total * (1 - data.discount_percent/100);
                    $('#cart-total').text(cart_total.toLocaleString());
                    $('#cart-discount').text(cart_discount.toLocaleString());
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
        var product_quantity = parseInt(row.find('.product-quantity').val()) - 1;
        row.find('.product-quantity').val(product_quantity);
        var quanity = parseInt($('.product-id-quantity').val());
        if(product_quantity > quanity){
            alert("Số lượng sản phẩm chỉ còn" + quanity);
        }else{
            var product_price = parseInt(row.find(".product-price-value").val());
            if (product_price == '') {
                product_price = 0;
            }
            var product_total = product_price * product_quantity;
            var old_product_total = parseInt(row.find(".product-total").text().replaceAll(',', ''));
            var total = calc_cart_total() - old_product_total + product_total;
            
            row.find(".product-total").text(product_total.toLocaleString());
            $('#cart-total').text(total.toLocaleString());

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
            alert("Số lượng sản phẩm chỉ còn " + quanity + " sản phẩm. Vui lòng giảm số lượng mua");
        }else{
            var product_price = parseInt(row.find(".product-price-value").val());
            if (product_price == '') {
                product_price = 0;
            }
            var product_total = product_price * product_quantity;
            var old_product_total = parseInt(row.find(".product-total").text().replaceAll(',', ''));
            var total = calc_cart_total() - old_product_total + product_total;
            
            row.find(".product-total").text(product_total.toLocaleString());
            $('#cart-total').text(total.toLocaleString());

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

