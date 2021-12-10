@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <div class="x_title">
      <h2>Danh sách đơn hàng</h2>
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
            <div class="alert alert-success" role="alert">
             <?php echo $message; ?>
             <i class="fa fa-times"></i>
            </div>
        <?php
        Session::put('message','');
      }
    ?>

    <div class="search_box">
                  <form action="{{URL::to('/search-order')}}"  method="GET">
                      {{csrf_field()}}
                  <input type="text" id="keywords" placeholder="Tìm kiếm ..." name="tukhoaorder">
                  <button type="submit" name="search-items" value="Tìm kiếm"><i class="fa fa-search"></i></button>
                  </form>
    </div> 
    <table class="table">
        <thead>
          <tr>
            <th>STT</th>
            <th style="width: 200px">Mã đơn hàng</th>
            <th style="width: 200px">Tên khách hàng</th>
            <th style="width: 200px">Ngày hóa đơn</th>
            <th style="width: 200px">Tổng tiền</th>
            <th style="width: 200px">Tình trạng</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $i =0 ; ?> 
        @foreach ($all_order as $keyOrd => $eachOrder)
        <tr>
          <th scope="row">{{++$i}}</th>
          <td>{{$eachOrder->order_id}}</td>
          <td>{{$eachOrder->shipping_name}}</td>
          <td>{{$eachOrder->order_date}}</td>
          <td>{{$eachOrder->order_total}}</td>
          <td align="center">
              <?php
              if ($eachOrder->order_status == 0){ ?>
            <a href="{{URL::to('/status-order/'.$eachOrder->order_id)}}"><button class="btn btn-danger btn-sm">Đã xử lý</button></a>
            <?php }else { ?>
              <a href="{{URL::to('/unstatus-order/'.$eachOrder->order_id)}}"><button class="btn btn-success btn-sm">Đang xử lý</button></a>
              <?php  } ?>
          </td>
          <td>
            <a href="{{URL::to('/detail-order/'.$eachOrder->order_id)}}" class="btn btn-sm btn-primary">Chi tiết</a>
            <a href="{{URL::to('/delete-order/'.$eachOrder->order_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa đơn hàng {{$eachOrder->order_id}} không?')">Xóa</a>
          </td>
        </tr>
        @endforeach
                
         
        </tbody>
      </table>

      <div class="row">
            <div class="col l-12 m-12 c-12 pagination_wrap">
                <div class="pagination">
                    <li style="display:inline;{{ ($all_order->currentPage() == 1) ? 'none;' : '' }}">
                        <a href="{{ $all_order->url(1) }}">&laquo;</a>
                    </li>
                    @for ($i = 1; $i <= $all_order->lastPage(); $i++)
                        <?php
                        $link_limit = 7;
                        $half_total_links = floor($link_limit / 2);
                        $from = $all_order->currentPage() - $half_total_links;
                        $to = $all_order->currentPage() + $half_total_links;
                        if ($all_order->currentPage() < $half_total_links) {
                            $to += $half_total_links - $all_order->currentPage();
                        }
                        if ($all_order->lastPage() - $all_order->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($all_order->lastPage() - $all_order->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li style="display:inline;" class="{{ ($all_order->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $all_order->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li style="display:inline;{{ ($all_order->currentPage() == $all_order->lastPage()) ? 'none;' : '' }}">
                        <a href="{{ $all_order->url($all_order->lastPage()) }}">&raquo;</a>
                    </li>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection