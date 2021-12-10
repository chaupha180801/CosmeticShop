@extends('frontLayout')
@section('frontEndContent')
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
                @foreach($content as $v_content)
                <tr>
                
                    <td class="product_thumb"><img src="{{asset('public/backEnd/images/'.$v_content->options->image)}}" height="100" width="100"></td>
                    <td class="product_name">{{$v_content->name}}</td>
                    <td class="product-price">{{number_format($v_content->price). ' VNĐ'}}</td>
                    
                    <!-- <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                    {{ csrf_field() }}
                        <td class="product_quantity" >
                           
                            <input min="1"  value="{{$v_content->qty}}" type="number" name="qty_cart">                            
                            <input class="product_quantity" type="hidden" value="{{$v_content->rowId}}" name="rowId_cart"> 
                        </td>                    
                        
                    </form>  -->
                    <td class="product_quantity" >   
                        <a href="{{URL::to('/decrement-cart-quantity/'.$v_content->rowId)}}">
                            <button>-</button>   
                        </a> 
                        <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                            {{ csrf_field() }}
                            <input class="product_quantity" type="hidden" value="{{$v_content->rowId}}" name="rowId_cart">
                        
                            <input min="1"  value="{{$v_content->qty}}" type="text" name="qty_cart"> 
                        </form> 
                         
                        <a href="{{URL::to('/increment-cart-quantity/'.$v_content->rowId)}}">
                            <button>+</button> 
                        </a>
                        
                    </td> 
                    <td class="product_total">
                        <?php
                         $subtotal = $v_content->price * $v_content->qty;
                         echo number_format($subtotal).' VNĐ';
                        ?>
                    </td>
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
            <td colspan="5" class="text-right"><h3><strong>Tổng số lượng: {{Cart::count()}}</strong></h3></td>
        </tr>
        <tr>
        
            <td colspan="5" class="text-right"><h3><strong>Thành tiền: {{Cart::subtotal().' VNĐ'}} </strong></h3></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>Tiếp tục mua sắm</a>
                <?php
                   $account_id = Session::get('account_id');
                   if($account_id !=NULL){
                    ?>
                    <a href="{{URL::to('/checkout')}}">
                            <button class="btn btn-success">Thanh toán</button>
                        </a>
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


@endsection

