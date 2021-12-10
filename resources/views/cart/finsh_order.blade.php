@extends('frontLayout')
@section('frontEndContent')
<div>
    <h3>Đơn hàng của bạn đã đặt thành công</h3>
    <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>Tiếp tục mua sắm</a>    
</div>
@endsection