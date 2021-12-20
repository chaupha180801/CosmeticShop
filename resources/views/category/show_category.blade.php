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
      <div class="search_box search_box_product_admin">
          <form action="{{URL::to('/search-category-admin')}}">
            {{ csrf_field() }}
            <input type="text" placeholder="Tìm kiếm..." name="tukhoacategory">
            <button type="submit" name="search-items" value="Tìm kiếm danh mục"><i class="fa fa-search"></i></button>
          </form>
      </div>
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
        @foreach ($all_category as $keyCategory => $eachCategory)
        <tr>
          <th scope="row">{{++$i}}</th>
          <td>{{$eachCategory->category_name}}</td>
          <td>{{$eachCategory->category_desc}}</td>
          <td align="center">
          <?php
          if ($eachCategory->category_status == 0){ ?>
         <a href="{{URL::to('/display-category-product/'.$eachCategory->category_id)}}"><button class="btn btn-danger btn-sm">Ẩn</button></a>
         <?php }else { ?>
          <a href="{{URL::to('/undisplay-category-product/'.$eachCategory->category_id)}}"><button class="btn btn-success btn-sm">Hiện</button></a>
           <?php  } ?>
         </td>
          <td>
            <a href="{{URL::to('/edit-category-product/'.$eachCategory->category_id)}}" class="btn btn-sm btn-primary">Sửa</a>
            <a href="{{URL::to('/delete-category-product/'.$eachCategory->category_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Danh mục {{$eachCategory->category_name}} vẫn còn tồn tại sản phẩm, ban có muốn xóa toàn bộ sản phẩm thuộc danh mục {{$eachCategory->category_name}} hay không?')">Xóa</a>
          </td>
        </tr>
        @endforeach
             
         
        </tbody>
      </table>
      <a href="{{URL::to('/add-category')}}" class="btn btn-primary">Thêm danh mục mới</a>
    </div>
    <div class="row">
            <div class="col l-12 m-12 c-12 pagination_wrap">
                <div class="pagination">
                    <li style="display:inline;{{ ($all_category->currentPage() == 1) ? 'none;' : '' }}">
                        <a href="{{ $all_category->url(1) }}">&laquo;</a>
                    </li>
                    @for ($i = 1; $i <= $all_category->lastPage(); $i++)
                        <?php
                        $link_limit = 7;
                        $half_total_links = floor($link_limit / 2);
                        $from = $all_category->currentPage() - $half_total_links;
                        $to = $all_category->currentPage() + $half_total_links;
                        if ($all_category->currentPage() < $half_total_links) {
                        $to += $half_total_links - $all_category->currentPage();
                        }
                        if ($all_category->lastPage() - $all_category->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($all_category->lastPage() - $all_category->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li style="display:inline;" class="{{ ($all_category->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $all_category->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li style="display:inline;{{ ($all_category->currentPage() == $all_category->lastPage()) ? 'none;' : '' }}">
                        <a href="{{ $all_category->url($all_category->lastPage()) }}">&raquo;</a>
                    </li>
                </div>
            </div>
    </div>
  </div>
@endsection