@extends('admin_layout')
@section('admin_content')
<style>
  .highcharts-figure,
  .highcharts-data-table table {
      min-width: 310px;
      max-width: 1250px;
      margin: 1em auto;
  }

  .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #ebebeb;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
  }

  .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
  }

  .highcharts-data-table th {
      font-weight: 600;
      padding: 0.5em;
  }

  .highcharts-data-table td,
  .highcharts-data-table th,
  .highcharts-data-table caption {
      padding: 0.5em;
  }

  .highcharts-data-table thead tr,
  .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
  }

  .highcharts-data-table tr:hover {
      background: #f1f7ff;
  }
</style>


{{-- <div class="row" style="display: inline-block;" > --}}
    <div class=" row tile_count">
      <div class="col-md-3  tile_stats_count" >
        <span class="count_top"><i class="fa fa-chart-bar"></i> Doanh thu tháng</span>
        <div class="count">{{number_format($dtt,0,',','.')}} vnd</div>
        <span class="count_bottom">Tăng<i class="green"><i class="fa fa-sort-asc"></i>4% </i> so với tháng trước </span>
      </div>
      <div class="col-md-3  tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Doanh thu năm</span>
        <div class="count">{{number_format($dtn,0,',','.')}} vnd</div>
        <span class="count_bottom">Tăng <i class="green"><i class="fa fa-sort-asc"></i>3% </i>so với năm trước</span>
      </div>
      <div class="col-md-3 tile_stats_count">
        <span class="count_top"><i class="fa fa-list-alt"></i> Số đơn hàng chờ xác nhận</span>
        <div class="count green">{{$dhxn}}</div>
       
      </div>
      <div class="col-md-3  tile_stats_count">
        <span class="count_top"><i class="fa fa-truck"></i> Số đơn hàng đang giao</span>
        <div class="count">{{$dhdg}}</div>
      </div>
    
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div>
              <div class="x_title">
                <h2>Sản phẩm bán chạy</h2>
              </div>
              <ul class="list-unstyled top_profiles scroll-view">
                <?php
                  $i = 1;
                ?>
                @foreach($search_product as $Key => $value)
                <li class="media event">
                  <a class="pull-left border-aero profile_thumb top_product_image">
                   <img src="{{URL::to('public/backEnd/images/'.$value->product_img)}}" alt="">
                  </a>
                  <div class="media-body">
                    <a class="title banchay_name" href="#">{{$value->product_name}}</a>
                    <p><strong class="banchay_gia">{{number_format($value->product_price,0,',','.')}} vnd </strong></p>
                  </div>
                  <div class="stt">
                    <i class="fas fa-award"></i>
                    <span><?php echo $i++ ?></span>
                </div>
                </li>
                @endforeach
              
              </ul>
            </div>
          </div>
    
    </div>
  <div class="row">
    <div class="col-md-12  widget_tally_box">
      <figure class="highcharts-figure">
      <div id="container" data-list-day="{{$listDay}}" data-total={{$arrayRevenue}}
          data-total-Estimated={{$arrayRevenueEstimated}}></div>
 
          <div id="container2" data-list-month="{{$listMonth}}" data-total-year={{$arrayRevenueYear}}
          data-total-order={{$arrayTotalYear}}></div>
      </figure>
    </div>
      
    
  </div>

    <script type="text/javascript">

      let listDay = $('#container').attr("data-list-day");
      listDay = JSON.parse(listDay);
      let month = new Date().getMonth() + 1;
      let total = $('#container').attr("data-total");
      total = JSON.parse(total);
      let totalEstimated = $('#container').attr("data-total-Estimated");
      totalEstimated = JSON.parse(totalEstimated);
      Highcharts.chart('container', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Biểu đồ doanh thu theo ngày trong tháng ' + month
            },
            subtitle: {
                text: 'CosmeticShop'
            },
            xAxis: {
                categories: listDay
            },
            yAxis: {
                title: {
                    text: 'Mức doanh thu'
                },
                labels: {
                    formatter: function () {
                        return this.value + ' VNĐ';
                    }
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [{
                name: 'Doanh thu',
                marker: {
                    symbol: 'square'
                },
                data: total
            },
            {
                name: 'Doanh thu dự tính',
                marker: {
                    symbol: 'square'
                },
                data: totalEstimated
            }
          ] 
        });
      

      let listMonth = $('#container2').attr("data-list-month");
      listMonth = JSON.parse(listMonth);
      let year = new Date().getFullYear();
      let totalYear = $('#container2').attr("data-total-year");
      totalYear = JSON.parse(totalYear);
      let totalOrder = $('#container2').attr("data-total-order");
      totalOrder = JSON.parse(totalOrder);
        Highcharts.chart('container2', {

          chart: {
              type: 'column',
              styledMode: true
          },

          title: {
              text: 'Biểu đồ doanh thu và tổng số đơn hàng theo tháng trong năm '+year
          },
          xAxis: {
                categories: listMonth
            },

          yAxis: [{
              className: 'highcharts-color-0',
              title: {
                  text: 'Số đơn hàng'
              }
              
          }, {
              className: 'highcharts-color-1',
              opposite: true,
              title: {
                  text: 'Mức doanh thu'
              },
           labels: {
                    formatter: function () {
                        return this.value + ' VNĐ';
                    }
                } 
          }],

          plotOptions: {
              column: {
                  borderRadius: 4
              }
          },

          series: [{
              name: 'Đơn hàng',
              data: totalOrder
          }, {
              name: 'Doanh thu',
              data: totalYear,
              yAxis: 1
          }]

          });

    </script>

  
@endsection

