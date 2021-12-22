@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <div class="x_title">
      <h2 class="admin_part_heading">Danh sách khách hàng</h2>
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
             <i class="fa fa-times" id="icon_hide_message" onclick="hidemessage()"</i>
            </div>
        <?php
        Session::put('message','');
      }
    ?>
      <table class="table">
        <thead>
          <tr>
            <th>STT</th>
            <th style="width: 300px">Tên khách hàng</th>
            <th style="width: 500px">Email</th>
            <th style="width: 200px">Số điện thoại</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
        <?php $i =0 ; ?>
        @foreach ($customer as $keyCus => $eachCustomer)
        <tr>
          <th scope="row">{{++$i}}</th>
          <td>{{$eachCustomer->account_name}}</td>
          <td>{{$eachCustomer->account_email}}</td>
          <td>{{$eachCustomer->account_phone}}</td>
          
          <td>
            <a href="{{URL::to('/edit-customer/'.$eachCustomer->account_id)}}" class="btn btn-sm btn-primary">Sửa</a>
            <a href="{{URL::to('/delete-customer/'.$eachCustomer->account_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa khách hàng {{$eachCustomer->account_name}} không?')">Xóa</a>
          </td>
        </tr>
        @endforeach
                
         
        </tbody>
      </table>
    </div>
  </div>
@endsection