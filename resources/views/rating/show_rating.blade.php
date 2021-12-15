@extends('admin_layout')
@section('admin_content')

<div class="x_panel">
    <div class="x_title">
      <h2 class="admin_part_heading">Danh sách các đánh giá</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
  
    <div class="x_content">
      <table class="table">
        <thead>
          <tr>
            <th>STT</th>
            <th>Duyệt</th>
            <th style="width: 200px">Tên khách hàng</th>
            <th style="width: 300px">Sản phẩm</th>
            <th >Nội dung</th>
            <th >Rating</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = ($all_rating->currentPage()-1)*5 ; ?>
        @foreach ($all_rating as $key => $each_rating)
        <tr>

            <th scope="row">{{++$i}}</th>
            <td align="center">
              <?php
              if ($each_rating->rating_status == 0){ ?>
                <a href="{{URL::to('/display-rating/'.$each_rating->rating_id)}}"><button class="btn btn-danger btn-sm" data-rating_status="{{$each_rating->rating_id}}">Duyệt</button></a>
                <?php }else { ?>
                  <a href="{{URL::to('/undisplay-rating/'.$each_rating->rating_id)}}"><button class="btn btn-success btn-sm" data-rating_status="{{$each_rating->rating_id}}">Bỏ duyệt</button></a>
                  <?php  } 
              ?>
            </td>
            <td>{{$each_rating->account_name}}</td>
            <td><a href="{{url('/chi-tiet-san-pham/'.$each_rating->product_id)}}" target="_blank" >{{$each_rating->product_name}}</a></td>
            <td>
              {{$each_rating->rating_content}}
              <ul>
                @foreach($all_reply as $key => $comm_reply)
                  @if($comm_reply->rating_parent_id == $each_rating->rating_id)
                    <li>{{$comm_reply->rating_content}}</li>
                  @endif
                @endforeach                
              </ul>            
              @if($each_rating->rating_status == 0)
                <textarea name="" cols="3" class="form control" id="reply_comment_{{$each_rating->rating_id}}"></textarea>
                <br><br><button class="btn_reply_comment btn btn-primary" data-rating_id="{{$each_rating->rating_id}}" data-product_id="{{$each_rating->product_id}}">Trả lời đánh giá</button>
              @endif
              </td>
            <td>{{$each_rating->rating_number}}<i class="fa fa-star " style="color: #ff9705"></i></td>
            <td>  
                <a href="{{URL::to('/delete-rating/'.$each_rating->rating_id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa đánh giá {{$each_rating->rating_content}} không?')">Xóa</a>
            </td>
        </tr>
        @endforeach
        
         
        </tbody>
      </table>
       <!-- Phân trang  -->
       <div class="row">
            <div class="col l-12 m-12 c-12 pagination_wrap">
                <div class="pagination">
                    <li style="display:inline;{{ ($all_rating->currentPage() == 1) ? 'none;' : '' }}">
                        <a href="{{ $all_rating->url(1) }}">&laquo;</a>
                    </li>
                    @for ($i = 1; $i <= $all_rating->lastPage(); $i++)
                    <?php
                        $link_limit = 7;
                        $half_total_links = floor($link_limit / 2);
                        $from = $all_rating->currentPage() - $half_total_links;
                        $to = $all_rating->currentPage() + $half_total_links;
                        if ($all_rating->currentPage() < $half_total_links) {
                            $to += $half_total_links - $all_rating->currentPage();
                        }
                        if ($all_rating->lastPage() - $all_rating->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($all_rating->lastPage() - $all_rating->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li style="display:inline;" class="{{ ($all_rating->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $all_rating->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li style="display:inline;{{ ($all_rating->currentPage() == $all_rating->lastPage()) ? 'none;' : '' }}">
                        <a href="{{ $all_rating->url($all_rating->lastPage()) }}">&raquo;</a>
                    </li>
                </div>
            </div>
        </div> 
        <!-- End phân trang -->
    </div>

  </div>


@endsection



