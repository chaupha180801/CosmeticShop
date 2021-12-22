@extends('admin_layout')
@section('admin_content')
<style>
  .rating .active{
    color: #ff9705 !important;
  }
</style>
<div class="x_panel">
    <div class="x_title">
      <h2  class="admin_part_heading">Danh sách sản phẩm</h2>
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
            <div class="alert alert-success" id="divmessage" role="alert">
             <?php echo $message; ?>
             <i class="fa fa-times"  id="icon_hide_message" onclick="hidemessage()"></i>
            </div>
        <?php
        Session::put('message','');
      }
    ?>
    <div class="row" style="justify-content: flex-end; margin: 10px 0;">
      <a href="{{URL::to('/show-product-admin')}}" class="btn btn-primary">Xem tất cả sản phẩm</a>
      <a href="{{URL::to('/add-product-admin')}}" class="btn btn-primary">Thêm sản phẩm mới</a>

    </div>
    <div class="row search_filer_product_admin">    
      <div class="col-md-8 filer_col">
        <label for="amount">Sắp xếp theo</label>
        <form id="form-sort">
            {{ csrf_field() }}
        <select name="sort_by" id="sort" form="form-sort" class="form-control">
            <option value="none">Lọc</option>
            <option value="tang_dan">Giá tăng dần</option>
            <option value="giam_dan">Giá giảm dần</option>
            <option value="kytu_az">Lọc theo tên A đến Z</option>
            <option value="kytu_za">Lọc theo tên Z đến A</option>
        </select>
        </form>  
      </div>  
      <div class="col-md-4 search_col">
        <div class="search_box">
          <form action="{{URL::to('/search-product')}}"  method="GET">
              {{csrf_field()}}
          <input type="text" id="keywords" placeholder="Tìm kiếm ..." name="tukhoa">
          <!-- <div id="search-ajax"></div> -->
          <button type="submit" name="search-items" value="Tìm kiếm"><i class="fa fa-search"></i></button>
          </form>
        </div> 
      </div>
    </div>     
    <div class="row">
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action table_product_admin">
          <thead>
            <tr class="headings">
              <th class="column-title">STT</th>

              <th class="column-title" style="width: 250px;">Tên sản phẩm</th>
              <th class="column-title">Thư viện hình ảnh</th>
<!--               <th class="column-title">Ảnh</th> -->
              <th class="column-title">Danh mục</th>
              <th class="column-title">Nhãn hiệu</th>
              <th class="column-title">Nhà cung cấp</th>
              <th class="column-title">Giá bán</th>
              <th class="column-title">Số lượng</th>
              <th class="column-title">Trạng thái</th>
              <th class="column-title">Tình trạng</th>

              <th class="column-title">Hành động </th>
            </tr>
          </thead>
          <tbody>
          

          
        </div>
        <?php $i = ($all_product->currentPage()-1)*5 + 1 ; ?>
          @foreach ($all_product as $keyProduct => $eachProduct)
          <?php
            $age = 0;
            if($eachProduct->product_total_comment){
              $age = round($eachProduct->product_total_rating / $eachProduct->product_total_comment,2);
            }
          ?>
         
          <tr>
            <th scope="row">{{$i++}}</th>
            <td class="product_name_admin">
              {{$eachProduct->product_name}}
              <div class="rating_product_admin">
                <span>Đánh giá: </span>
                <span class="rating">
                  @for($j=1;$j<=5;$j++)
                     <i class="fa fa-star {{$j <= $age ? 'active' : '' }}"  style="color: #999"></i>
                  @endfor
                </span>
                <span>{{$age}}</span>
                </div>
            </td>
            <td><a href="{{URL::to('add-gallery/'.$eachProduct->product_id)}}">Thư viện ảnh</a></td> 
<!--             <td><img src="{{asset('public/backEnd/images/'.$eachProduct->product_img)}}" height="100" width="100"</td>  -->           
            <td >{{$eachProduct->category_name}}</td>
            <td>{{$eachProduct->brand_name}}</td>
            <td>{{$eachProduct->supplier_name}}</td>
            <td>{{number_format($eachProduct->product_price). '(đ)'}}</td>
            <td>{{$eachProduct->product_quanity}}</td>
            <td align="center">
            <?php
            if ($eachProduct->product_state == 0){ ?>
            <a href="{{URL::to('/state-product/'.$eachProduct->product_id)}}"><button class="btn btn-danger btn-sm">Ẩn</button></a>
            <?php }else { ?>
              <a href="{{URL::to('/unstate-product/'.$eachProduct->product_id)}}"><button class="btn btn-success btn-sm">Hiện</button></a>
              <?php  } ?>
            </td>
            <td align="center">
              <?php
              if ($eachProduct->product_status == 0){ ?>
            <a href="{{URL::to('/status-product/'.$eachProduct->product_id)}}"><button class="btn btn-danger btn-sm">Hết</button></a>
            <?php }else { ?>
              <a href="{{URL::to('/unstatus-product/'.$eachProduct->product_id)}}"><button class="btn btn-success btn-sm">Còn</button></a>
              <?php  } ?>
            </td>
              
            <td>
              <a href="{{URL::to('/edit-product/'.$eachProduct->product_id)}}" class="btn btn-sm btn-primary">Sửa</a>
              <a href="{{URL::to('/delete-product/'.$eachProduct->product_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa nhãn hiệu {{$eachProduct->product_name}} không?')">Xóa</a>
            </td>
          </tr>
        @endforeach

          </tbody>
        </table>
        
       

        <!-- Phân trang sản phẩm -->
        <div class="row">
            <div class="col l-12 m-12 c-12 pagination_wrap">
                <div class="pagination">
                    <li style="display:inline;{{ ($all_product->currentPage() == 1) ? 'none;' : '' }}">
                        <a href="{{ $all_product->url(1) }}">&laquo;</a>
                    </li>
                    @for ($i = 1; $i <= $all_product->lastPage(); $i++)
                        <?php
                        $link_limit = 7;
                        $half_total_links = floor($link_limit / 2);
                        $from = $all_product->currentPage() - $half_total_links;
                      
                        $to = $all_product->currentPage() + $half_total_links;
                      
                        if ($all_product->currentPage() < $half_total_links) {
                            $to += $half_total_links - $all_product->currentPage();
                        }
                        if ($all_product->lastPage() - $all_product->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($all_product->lastPage() - $all_product->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li style="display:inline;" class="{{ ($all_product->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $all_product->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li style="display:inline;{{ ($all_product->currentPage() == $all_product->lastPage()) ? 'none;' : '' }}">
                        <a href="{{ $all_product->url($all_product->lastPage()) }}">&raquo;</a>
                    </li>
                </div>
            </div>
        </div>
        <!-- End phân trang sản phẩm -->


      </div>
    </div>
  </div>

 
@endsection

