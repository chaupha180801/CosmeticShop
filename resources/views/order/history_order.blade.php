@extends('frontLayout')
@section('frontEndContent')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Lịch sử đơn hàng
    </div>
    <div class="table-responsive">
      <?php
        $message = Session::get('message');         
        if($message){
          echo '<span class="text-alert">'.$message.'</span>';
          Session::put('message',null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th class="column-title">STT</th>
            <th class="column-title">Ngày đặt hàng</th>
            <th class="column-title">Tổng giá tiền</th>
            <th class="column-title">Tình trạng</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        <?php $i =0 ; ?>
          @foreach($all_orders as $key => $order)
          <tr class = "row_order">
            <th scope="row" class = "stt_order">{{++$i}}</th>
            
            <td>{{ $order->order_date }}</td>
            <td>{{ $order->order_total }} VNĐ</td>
            <td>{{ $order->order_status }}</td>
            <td>
              <div>
                <input type ="hidden" class = "order_detail_id" value="{{$order->order_id}}">
                <button class="see_all_detail_order">
                  <span class="order_history_text">Xem chi tiết</span>
                </button>
              </div>
              <div class="form_order">

              </div>
            </td>
          </tr>
           @endforeach           

        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
              <!-- Phân trang đơn hàng -->
              <div class="row">
            <div class="col l-12 m-12 c-12 pagination_wrap">
                <div class="pagination">
                    <li style="display:inline;{{ ($all_orders->currentPage() == 1) ? 'none;' : '' }}">
                        <a href="{{ $all_orders->url(1) }}">&laquo;</a>
                    </li>
                    @for ($i = 1; $i <= $all_orders->lastPage(); $i++)
                        <?php
                        $link_limit = 7;
                        $half_total_links = floor($link_limit / 2);
                        $from = $all_orders->currentPage() - $half_total_links;
                        $to = $all_orders->currentPage() + $half_total_links;
                        if ($all_orders->currentPage() < $half_total_links) {
                            $to += $half_total_links - $all_orders->currentPage();
                        }
                        if ($all_orders->lastPage() - $all_orders->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($all_orders->lastPage() - $all_orders->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li style="display:inline;" class="{{ ($all_orders->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $all_orders->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li style="display:inline;{{ ($all_orders->currentPage() == $all_orders->lastPage()) ? 'none;' : '' }}">
                        <a href="{{ $all_orders->url($all_orders->lastPage()) }}">&raquo;</a>
                    </li>
                </div>
            </div>
        </div>
        <!-- End phân trang đơn hàng -->
    </footer>
    </div>
      <script type="text/javascript">
        var x = document.getElementsByClassName("form_order");
        for(let i = 0; i <x.length; i++)
        {
          x[i].style.display = "none";
        }
        $('.see_all_detail_order').click(function(event){
          event.preventDefault();
          var row = $(this).parent().parent().parent();
          var stt = parseInt(row.find('.stt_order').text()) - 1;
          var order_id = row.find('.order_detail_id').val();
          var _token = $('input[name="_token"]').val();
          var y = document.getElementsByClassName("form_order")[stt];
          if(y.style.display === "none")
          {
            y.style.display = "block";
            row.find(".order_history_text").text('Đóng lại');
            $.ajax(
              {
                url: "{{url('/show-purchase-order-details')}}",
                method: "post",
                data: {order_id:order_id,_token:_token},
                success:function(data)
                {
                  row.find('.form_order').html(data);
                }
              });
            }else {
              row.find(".order_history_text").text('Xem chi tiết');
              y.style.display = "none";
            }
        });
      </script>
</div>
@endsection