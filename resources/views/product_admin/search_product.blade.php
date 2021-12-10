@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <div class="x_title">
      <h2  class="admin_part_heading">Tìm kiếm sản phẩm</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
        <li class="dropdown">
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <!-- <div class="search_box">
                  <form action="{{URL::to('/search-product')}}" autocomplete="off" method="GET">
                      {{csrf_field()}}
                  <input type="text" id="keywords" placeholder="Tìm kiếm ..." name="tukhoa">
                  <div id="search-ajax"></div>
                  <button type="submit" name="search-items" value="Tìm kiếm"><i class="fa fa-search"></i></button>
                  </form>
    </div>  -->
    <div class="x_content">
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action table_product_admin">
          <thead>
            <tr class="headings">
              <th class="column-title">STT</th>
              <th class="column-title">Tên sản phẩm </th>
              <th class="column-title">Ảnh sản phẩm </th>
              <th class="column-title">Danh mục </th>
              <th class="column-title">Nhãn hiệu </th>
              <th class="column-title">Nhà cung cấp </th>
              <th class="column-title">Giá bán </th>
              <th class="column-title">Số lượng </th>
              <th class="column-title">Trạng thái </th>
              <th class="column-title">Hành động </th>
            </tr>
          </thead>

          <tbody>
          <?php $i =0 ; ?>
        @foreach ($search as $keyProduct => $eachProduct)
        <tr>
          <th scope="row">{{++$i}}</th>
          <td>{{$eachProduct->product_name}}</td>
          <td><img src="public/backEnd/images/{{$eachProduct->product_img}}" height="100" width="100"</td>
          
          <td>{{$eachProduct->category_name}}</td>
          <td>{{$eachProduct->brand_name}}</td>
          <td>{{$eachProduct->supplier_name}}</td>
          <td>{{$eachProduct->product_price}}</td>
          <td>{{$eachProduct->product_quanity}}</td>
          <td align="center">
          <?php
          if ($eachProduct->product_status == 0){ ?>
         <a href="{{URL::to('/display-product/'.$eachProduct->product_id)}}"><button class="btn btn-danger btn-sm">Ẩn</button></a>
         <?php }else { ?>
          <a href="{{URL::to('/undisplay-product/'.$eachProduct->product_id)}}"><button class="btn btn-success btn-sm">Hiện</button></a>
           <?php  } ?>
         </td>
          <td>
            <a href="{{URL::to('/edit-product/'.$eachProduct->product_id)}}" class="btn btn-sm btn-primary">Sửa</a>
            <a href="{{URL::to('/delete-product/'.$eachProduct->product_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm {{$eachProduct->product_name}} không?')">Xóa</a>
          </td>
        </tr>
        @endforeach
           
          </tbody>
        </table>
        <!-- <a href="{{URL::to('/add-product-admin')}}" class="btn btn-success">Thêm sản phẩm mới</a> -->
      </div>
              
          
    </div>
  </div>
@endsection