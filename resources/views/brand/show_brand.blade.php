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
     <div class="search_box search_box_product_admin">
          <form action="{{URL::to('/search-brand-admin')}}" method ="GET">
            {{ csrf_field() }}
            <input type="text" placeholder="Tìm kiếm..." name="tukhoabrand">
            <button type="submit" name="search-items" value="Tìm kiếm danh mục"><i class="fa fa-search"></i></button>
          </form>
      </div>
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
          <?php $i = ($all_brand->currentPage()-1)*5 ; ?>
        @foreach ($all_brand as $keyBrand => $eachBrand)
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
            <a href="{{URL::to('/delete-brand/'.$eachBrand->brand_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Nhãn hiệu {{$eachBrand->brand_name}} vẫn còn tồn tại sản phẩm, ban có muốn xóa toàn bộ sản phẩm thuộc nhãn hiệu {{$eachBrand->brand_name}} hay không?')">Xóa</a>
          </td>
        </tr>
        @endforeach
                
         
        </tbody>
      </table>
      <a href="{{URL::to('/add-brand')}}" class="btn btn-primary">Thêm nhãn hiệu mới</a>

      <div class="row">
            <div class="col l-12 m-12 c-12 pagination_wrap">
                <div class="pagination">
                    <li style="display:inline;{{ ($all_brand->currentPage() == 1) ? 'none;' : '' }}">
                        <a href="{{ $all_brand->url(1) }}">&laquo;</a>
                    </li>
                    @for ($i = 1; $i <= $all_brand->lastPage(); $i++)
                        <?php
                        $link_limit = 7;
                        $half_total_links = floor($link_limit / 2);
                        $from = $all_brand->currentPage() - $half_total_links;
                        $to = $all_brand->currentPage() + $half_total_links;
                        if ($all_brand->currentPage() < $half_total_links) {
                            $to += $half_total_links - $all_brand->currentPage();
                        }
                        if ($all_brand->lastPage() - $all_brand->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($all_brand->lastPage() - $all_brand->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li style="display:inline;" class="{{ ($all_brand->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $all_brand->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li style="display:inline;{{ ($all_brand->currentPage() == $all_brand->lastPage()) ? 'none;' : '' }}">
                        <a href="{{ $all_brand->url($all_brand->lastPage()) }}">&raquo;</a>
                    </li>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection