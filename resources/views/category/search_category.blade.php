@extends('admin_layout')

@section('admin_content')

<div class="x_panel">
    <div class="x_title">
      <h2 class="admin_part_heading">Danh sách danh mục</h2>
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
            <th style="width: 200px">Tên danh mục</th>
            <th style="width: 500px">Mô tả danh mục</th>
            <th >Tình trạng (nhấn để thay đổi)</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $i =0 ; ?>
        @foreach($category as $key => $dmsp)
        <tr>
          <th scope="row">{{++$i}}</th>
          <td>{{$dmsp->category_name}}</td>
          <td>{{$dmsp->category_desc}}</td>
          <td align="center">
          <?php
          if ($dmsp->category_status == 0){ ?>
         <a href="{{URL::to('/display-category-product/'.$dmsp->category_id)}}"><button class="btn btn-danger btn-sm">Ẩn</button></a>
         <?php }else { ?>
          <a href="{{URL::to('/undisplay-category-product/'.$dmsp->category_id)}}"><button class="btn btn-success btn-sm">Hiện</button></a>
           <?php  } ?>
         </td>
          <td>
            <a href="{{URL::to('/edit-category-product/'.$dmsp->category_id)}}" class="btn btn-sm btn-primary">Sửa</a>
            <a href="{{URL::to('/delete-category-product/'.$dmsp->category_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa danh mục {{$dmsp->category_name}} không?')">Xóa</a>
          </td>
        </tr>
        @endforeach            
        </tbody>
      </table>
    </div>
  </div>
@endsection