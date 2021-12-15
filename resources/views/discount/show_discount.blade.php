@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <div class="x_title">
      <h2 class="admin_part_heading">Danh sách khuyến mãi</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
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
              <div class="alert alert-success" id="divmessage" role="alert">
              <?php echo $message; ?>
              <i class="fa fa-times" onclick="hidemessage()"></i>
              </div>
          <?php
          Session::put('message','');
        }
      ?>
      
      <table class="table">
        <thead>
          <tr>
              <th>STT</th>
              <th>Mã code</th>
              <th>Mô tả khuyến mãi</th>
              <th>Phần trăm giảm giá</th>
              <th>Số lượng</th>
              <th>Ngày bắt đầu</th>
              <th>Ngày kết thúc</th>
              <th>Gửi mã giảm giá</th>
              <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $i =0 ; ?>
        @foreach ($all_discount as $keyDiscount => $eachDiscount)
        <tr>
            <th scope="row">{{++$i}}</th>
            <td>{{$eachDiscount->discount_code}}</td>
            <td>{{$eachDiscount->discount_desc}}</td>
            <td>{{$eachDiscount->discount_percent}}%</td>
            <td>{{$eachDiscount->discount_quantity}}</td>
            <td>{{Carbon\Carbon::parse($eachDiscount->discount_start)->format('Y-m-d')}}</td>
            <td>{{Carbon\Carbon::parse($eachDiscount->discount_end)->format('Y-m-d')}}</td>
            <td>
              <a href="{{url('/coupon',[
                'percent'=>$eachDiscount->discount_percent,
                'quantity'=>$eachDiscount->discount_quantity,
                'desc'=>$eachDiscount->discount_desc,
                'code'=>$eachDiscount->discount_code
                ])}}" class="btn btn-sm btn-primary">Gửi mã</a>
            </td>
            <td>
              <a href="{{URL::to('/edit-discount/'.$eachDiscount->discount_id)}}" class="btn btn-sm btn-primary">Sửa</a>
              <a href="{{URL::to('/delete-discount/'.$eachDiscount->discount_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa khuyến mãi  {{$eachDiscount->discount_code}}  không?')">Xóa</a>
            </td>
            
        </tr>
        @endforeach
                
         
        </tbody>
      </table>
      <a href="{{URL::to('/add-discount')}}" class="btn btn-primary">Thêm khuyến mãi mới</a>
    </div>
  </div>
@endsection