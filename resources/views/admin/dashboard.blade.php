@extends('admin_layout')
@section('admin_content')
{{-- <div class="row" style="display: inline-block;" > --}}
    <div class=" row tile_count">
      <div class="col-md-3  tile_stats_count" >
        <span class="count_top"><i class="fa fa-chart-bar"></i> Doanh thu tháng</span>
        <div class="count">25.000.000 vnd</div>
        <span class="count_bottom">Tăng<i class="green"><i class="fa fa-sort-asc"></i>4% </i> so với tháng trước </span>
      </div>
      <div class="col-md-3  tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Doanh thu năm</span>
        <div class="count">200.000.000 vnd</div>
        <span class="count_bottom">Tăng <i class="green"><i class="fa fa-sort-asc"></i>3% </i>so với năm trước</span>
      </div>
      <div class="col-md-3 tile_stats_count">
        <span class="count_top"><i class="fa fa-list-alt"></i> Số đơn hàng chờ xác nhận</span>
        <div class="count green">30</div>
       
      </div>
      <div class="col-md-3  tile_stats_count">
        <span class="count_top"><i class="fa fa-truck"></i> Số đơn hàng đang giao</span>
        <div class="count">129</div>
      </div>
    
    </div>
  {{-- </div> --}}
  <div class="row">
    <div class="col-md-8  widget_tally_box">
        <div class="x_panel">
          <div class="x_title">
            <h2>Biểu đồ doanh thu</h2>
          </div>
          <div class="x_content">
            <div id="graph_bar" style="width:100%; height:200px;"></div>
          </div>
        </div>
      </div>
      
    <div class="col-md-3 col-sm-12 ">
        <div>
          <div class="x_title">
            <h2>Sản phẩm bán chạy</h2>
          </div>
          <ul class="list-unstyled top_profiles scroll-view">
            <li class="media event">
              <a class="pull-left border-aero profile_thumb top_product_image">
               <img src="{{URL::to('public/backEnd/images/21.jpg')}}" alt="">
              </a>
              <div class="media-body">
                <a class="title" href="#">Kem dưỡng da</a>
                <p><strong>30.000 vnd </strong></p>
              </div>
              <div class="stt">
                <i class="fas fa-award"></i>
                <span>1</span>
            </div>
            </li>
            <li class="media event">
                <a class="pull-left border-aero profile_thumb top_product_image">
                 <img src="{{URL::to('public/backEnd/images/21.jpg')}}" alt="">
                </a>
                <div class="media-body">
                  <a class="title" href="#">Kem dưỡng da</a>
                  <p><strong>30.000 vnd </strong></p>
                </div>
                <div class="stt">
                    <i class="fas fa-award"></i>
                    <span>3</span>
                </div>
              </li>
              <li class="media event">
                <a class="pull-left border-aero profile_thumb top_product_image">
                 <img src="{{URL::to('public/backEnd/images/21.jpg')}}" alt="">
                </a>
                <div class="media-body">
                  <a class="title" href="#">Kem dưỡng da</a>
                  <p><strong>30.000 vnd </strong></p>
                </div>
                <div class="stt">
                    <i class="fas fa-award"></i>
                    <span>3</span>
                </div>
              </li>
              <li class="media event">
                <a class="pull-left border-aero profile_thumb top_product_image">
                 <img src="{{URL::to('public/backEnd/images/21.jpg')}}" alt="">
                </a>
                <div class="media-body">
                  <a class="title" href="#">Kem dưỡng da</a>
                  <p><strong>30.000 vnd </strong></p>
                </div>
                <div class="stt">
                    <i class="fas fa-award"></i>
                    <span>4</span>
                </div>
              </li>
              <li class="media event">
                <a class="pull-left border-aero profile_thumb top_product_image">
                 <img src="{{URL::to('public/backEnd/images/21.jpg')}}" alt="">
                </a>
                <div class="media-body">
                  <a class="title" href="#">Kem dưỡng da</a>
                  <p><strong>30.000 vnd </strong></p>
                </div>
                <div class="stt">
                    <i class="fas fa-award"></i>
                    <span>5</span>
                </div>
              </li>
          
          </ul>
        </div>
      </div>

  </div>
@endsection