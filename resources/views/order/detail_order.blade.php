@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <!-- Phần thông tin khách hàng -->
    <div class="x_title">
        <h2 class="admin_part_heading">Thông tin khách hàng </h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php
      $message = Session::get('message');
      if ($message)
      {
        ?>
            <div class="alert alert-success" role="alert">
             <?php echo $message; ?>
             <i class="fa fa-times"></i>
            </div>
        <?php
        Session::put('message','');
      }
        ?>
        <table class="table">
        <thead>
            <tr>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Email</th>

                <!-- <th style="width:30px;"></th> -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$account->account_name}}</td>
                <td>{{$account->account_phone}}</td>
                <td>{{$account->account_email}}</td>
            </tr>
        </tbody>
        </table>
    </div>
<!-- Phần thông tin vận chuyển  -->
    <div class="x_title">
        <h2 class="admin_part_heading">Thông tin vận chuyển </h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php
        $message = Session::get('message');
        if ($message)
        {
            ?>
                <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
                <i class="fa fa-times"></i>
                </div>
            <?php
            Session::put('message','');
        }
        ?>
        <table class="table">

            <thead>
                <tr>
                    <th>Tên người nhận</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Ghi chú</th>

                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$shipping->shipping_name}}</td>
                    <td>{{$shipping->shipping_address}}</td>
                    <td>{{$shipping->shipping_phone}}</td>
                    <td>{{$shipping->shipping_email}}</td>
                    <td>{{$shipping->shipping_note}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
<!-- Phần chi tiết đơn hàng -->
    <div class="x_title">
        <h2 class="admin_part_heading">Liệt kê chi tiết đơn hàng </h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php
        $message = Session::get('message');
        if ($message)
        {
            ?>
                <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
                <i class="fa fa-times"></i>
                </div>
            <?php
            Session::put('message','');
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá sản phẩm</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
                    <tbody>
                    <?php $i =0 ;
                        $total = 0; 
                    ?>
                    @foreach($detail_order as $key => $details)
                        @php
                        $subtotal = $details->product_price*$details->order_product_quanity;
                        $total += $subtotal;
                        @endphp
                    <tr>
                        <th scope="row">{{++$i}}</th>
                        <td>{{$details->product_name}}</td>
                        <td>{{$details->order_product_quanity}}</td>
                        <td>{{number_format($details->product_price,0,',','.')}}đ</td>
                        <td>{{number_format($subtotal,0,',','.')}}đ</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>Thanh toán: {{number_format($total,0,',','.')}}đ</td>
                    </tr>
                    </tbody>                
        </table>
        <div class="ln_solid"></div>
        <div class="item form-group">
            <div class="col-md-6 col-sm-6">
                <a class="btn btn-primary" href="{{URL::to('/show-order-admin')}}" type="button">Danh sách đơn hàng</a>
            </div>
        </div> 
    </div>
    </div>
            
    
</div>
@endsection