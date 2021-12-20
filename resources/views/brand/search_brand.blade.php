@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <div class="x_title">
      <h2 class="admin_part_heading">Danh sách nhãn hiệu</h2>
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
             <i class="fa fa-times" id="icon_hide_message" onclick="hidemessage()"></i>
            </div>
        <?php
        Session::put('message','');
      }
    ?>
      <table class="table">
        <thead>
          <tr>
            <th>STT</th>
            <th style="width: 200px">Tên thương hiệu</th>
            <th style="width: 500px">Mô tả thương hiệu</th>
            <th >Tình trạng (nhấn để thay đổi)</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $i =0 ; ?>
        @foreach ($brand as $keyBrand => $eachBrand)
        <tr>
          <th scope="row">{{++$i}}</th>
          <td>{{$eachBrand->brand_name}}</td>
          <td>{{$eachBrand->brand_desc}}</td>
          <td align="center">
          <?php
          if ($eachBrand->brand_status == 0){ ?>
         <a href="{{URL::to('/display-brand/'.$eachBrand->brand_id)}}"><button class="btn btn-danger btn-sm">Ẩn</button></a>
         <?php }else { ?>
          <a href="{{URL::to('/undisplay-brand/'.$eachBrand->brand_id)}}"><button class="btn btn-success btn-sm">Hiện</button></a>
           <?php  } ?>
         </td>
          <td>
            <a href="{{URL::to('/edit-brand/'.$eachBrand->brand_id)}}" class="btn btn-sm btn-primary">Sửa</a>
            <a href="{{URL::to('/delete-brand/'.$eachBrand->brand_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa nhãn hiệu {{$eachBrand->brand_name}} không?')">Xóa</a>
          </td>
        </tr>
        @endforeach
                
         
        </tbody>
      </table>
    </div>
  </div>
@endsection