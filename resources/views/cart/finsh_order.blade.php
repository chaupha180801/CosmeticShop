@extends('frontLayout')
@section('frontEndContent')

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="success_order">
                <i class="far fa-check-circle"></i>
                <p>Bạn đã đặt đơn hàng thành công!</p>
                <div class="success_button">
                    <a href="{{ url('/') }}" class="btn btn-warning">Tiếp tục mua sắm</a>
                    <a href="{{URL::to('/history-order')}}" class="btn btn-primary">Lịch sử mua hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection