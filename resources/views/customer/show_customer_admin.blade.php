@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <div class="x_title">
      <h2>Danh sách khách hàng</h2>
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
             <i class="fa fa-times" id="icon_hide_message" onclick="hidemessage()"></i>
            </div>
        <?php
        Session::put('message','');
      }
    ?>

    <div class="search_box">
      <form action="{{URL::to('/search-customer')}}"  method="GET">
        {{csrf_field()}}
        <input type="text" id="keywords" placeholder="Tìm kiếm ..." name="tukhoacustomer">
        <button type="submit" name="search-items" value="Tìm kiếm" class="search_button"><i class="fa fa-search"></i></button>
      </form>
    </div> 
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
          <?php $i = ($all_customer->currentPage()-1)*5 ; ?>
        @foreach ($all_customer as $keyCus => $eachCustomer)
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
      <a href="{{URL::to('/add-customer')}}" class="btn btn-primary">Thêm khách hàng mới</a>

      <div class="row">
            <div class="col l-12 m-12 c-12 pagination_wrap">
                <div class="pagination">
                    <li style="display:inline;{{ ($all_customer->currentPage() == 1) ? 'none;' : '' }}">
                        <a href="{{ $all_customer->url(1) }}">&laquo;</a>
                    </li>
                    @for ($i = 1; $i <= $all_customer->lastPage(); $i++)
                        <?php
                        $link_limit = 7;
                        $half_total_links = floor($link_limit / 2);
                        $from = $all_customer->currentPage() - $half_total_links;
                        $to = $all_customer->currentPage() + $half_total_links;
                        if ($all_customer->currentPage() < $half_total_links) {
                            $to += $half_total_links - $all_customer->currentPage();
                        }
                        if ($all_customer->lastPage() - $all_customer->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($all_customer->lastPage() - $all_customer->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li style="display:inline;" class="{{ ($all_customer->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $all_customer->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li style="display:inline;{{ ($all_customer->currentPage() == $all_customer->lastPage()) ? 'none;' : '' }}">
                        <a href="{{ $all_customer->url($all_customer->lastPage()) }}">&raquo;</a>
                    </li>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection