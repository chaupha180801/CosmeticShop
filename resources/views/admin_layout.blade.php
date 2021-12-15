<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Admin Page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap -->
    <link href="{{asset('public/backEnd/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('public/backEnd/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
   
    <!-- NProgress -->
    <link href="{{asset('public/backEnd/vendors/nprogress/nprogress.css" rel="stylesheet')}}">
    <!-- iCheck -->
    <link href="{{asset('public/backEnd/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="{{asset('public/backEnd/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('public/backEnd/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('public/backEnd/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
   
    <!-- Custom Theme Style -->
    
   
    <link rel="stylesheet" href="{{asset('public/backEnd/build/css/custom.min.css')}}" >
    <link rel="stylesheet" href="{{asset('public/backEnd/build/css/style.css?v=').time()}}">
    
    
    <link href="{{('public/backEnd/build/css/extra.css?v=').time()}}" rel="stylesheet">
    <link href="{{('public/backEnd/build/css/extra2.css?v=').time()}}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <script type="text/javascript">
        $(document).ready(function(){
            $('#sort').on('change', function(){
                $('#form-sort').submit();
                return false;    
            });
        });

    </script>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><img src="{{asset('public/backEnd/images/logo_notext1.png')}}" alt="" class="logo_admin"> <span>Beauty Group</span></a>
            </div>

            <div class="clearfix"></div>
            <?php
            $name = Session::get('adminUserName');
            $admin_id = Session::get('adminId');
            $admin_img = Session::get('adminImg');

          ?>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{asset('public/backEnd/images/'.$admin_img)}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>
                <?php echo $name ?>
                </h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
            
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-product-hunt"></i> Sản phẩm <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/show-product-admin')}}">Danh sách sản phẩm</a></li>
                      <li><a href="{{URL::to('/add-product-admin')}}">Thêm sản phẩm</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-star"></i></i>Đánh giá<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/show-rating')}}">Danh sách đánh giá</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Danh mục <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/show-category')}}">Danh sách danh mục</a></li>
                      <li><a href="{{URL::to('/add-category')}}">Thêm danh mục</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-tags"></i></i> Nhãn hiệu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/show-brand')}}">Danh sách nhãn hiệu</a></li>
                      <li><a href="{{URL::to('/add-brand')}}">Thêm nhãn hiệu</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-users"></i></i> Nhà cung cấp <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/show-supplier')}}">Danh sách nhà cung cấp</a></li>
                      <li><a href="{{URL::to('/add-supplier')}}">Thêm nhà cung cấp</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-list-alt"></i> Đơn hàng <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/show-order-admin')}}">Danh sách đơn hàng</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-user"></i> Thông tin khách hàng <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/show-customer-admin')}}">Danh sách khách hàng</a></li>
                      <li><a href="{{URL::to('/add-customer')}}">Thêm khách hàng</a></li>
                    </ul>
                  </li>
                    
                  <li><a><i class="fa fa-percent"></i>Khuyến mãi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/show-discount')}}">Danh sách khuyến mãi</a></li>
                      <li><a href="{{URL::to('/add-discount')}}">Thêm khuyến mãi</a></li>
                    </ul>
                  </li>
                  <!-- <li><a><i class="fa fa-list-alt"></i> Đơn hàng <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{URL::to('/')}}">Danh sách đơn hàng</a></li>
                    </ul>
                  </li> -->
                  <!-- <li><a><i class="fa fa-user"></i> Thông tin khách hàng <span class="fa fa-chevron-down"></span></a></li> -->
                </ul>
              </div>


            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('public/backEnd/images/'.$admin_img)}}" alt="">
                    <?php
                    $name = Session::get('adminUserName');
                    if ($name)
                    {
                     echo $name;
                    }
                  ?>
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="{{URL::to('/profile-admin/'.$admin_id)}};" > Profile</a>
                      <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                  <a class="dropdown-item"  href="javascript:;">Help</a>
                    <a class="dropdown-item"  href="{{URL::to('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>

                {{-- <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> --}}
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
         

          {{-- content here --}}
          @yield('admin_content')
         
       
        </div>
          <!-- /top tiles -->

        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Make by beauty group</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    
    <!-- jQuery -->
    <script src="{{asset('public/backEnd/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('public/backEnd/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('public/backEnd/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('public/backEnd/vendors/nprogress/nprogress.j')}}s"></script>
    <!-- Chart.js -->
    <script src="{{asset('public/backEnd/vendors/Chart.js/dist/Chart.min.js')}}"></script>
    <!-- gauge.js -->
    <script src="{{asset('public/backEnd/vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('public/backEnd/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('public/backEnd/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('public/backEnd/vendors/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('public/backEnd/vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <script src="{{asset('public/backEnd/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/flot.curvedlines/curvedLines.js')}}"></script>
    <!-- DateJS -->
    <script src="{{asset('public/backEnd/vendors/DateJS/build/date.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('public/backEnd/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('public/backEnd/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('public/backEnd/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('public/backEnd/build/js/custom.min.js')}}"></script>


    <script type="text/javascript">
      $('.btn_reply_comment').click(function () {
        var rating_id = $(this).data('rating_id');
        var comment = $('#reply_comment_'+rating_id).val();        
        var rating_product_id = $(this).data('product_id');
        var rating_status = $(this).data('rating_status');
       
        $.ajax({
          url:"{{url('/reply-comment')}}",
          method:"POST",
          headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data:{comment:comment,rating_id:rating_id,rating_product_id:rating_product_id},
          success:function(data) {
            $('#reply_comment_'+rating_id).val('');
            location.reload();
            return false;
          }
        })
      });
    </script>
    
    <!-- Lọc sản phẩm -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#sort').on('change', function(){
                $('#form-sort').submit();
                return false;    
            });
        });
    </script>

    
    
    <script type="text/javascript">
      $(document).ready(function(){
        load_gallery();

         function load_gallery(){
            var pro_id = $('.pro_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
              url:"{{url('/select-gallery')}}",
              method: "POST",
              data:{pro_id:pro_id,_token:_token},
              success: function(data){
                $('.gallery_load').html(data);
              }
            });
          }

          $('#file').change(function(){
            var error = '';
            var files = $('#file')[0].files;

            if(files.length > 4){
              error+='<p>Chỉ được chọn tối đa 4 ảnh<p>';
            }else if(files.lenght==''){
              error+='<p>Bạn không được bỏ trống ảnh</p>';
            }else if(files.size > 2000000){
              error+='<p>File ảnh không được lớn hơn 2MB</p>';
            }

            if(error ==''){

            }else{
              $('#file').val();
              $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
              return false;
            }
          });

          $(document).on('blur','.edit_gallery_name',function(){
              var gal_id = $(this).data('gal_id');
              var gal_text = $(this).text();
              var _token = $('input[name="_token"]').val();
              $.ajax({
              url:"{{url('/update-gallery-name')}}",
              method: "POST",
              data:{gal_id:gal_id,gal_text:gal_text,_token:_token},
              success: function(data){
                load_gallery();
                $('#error_gallery').html('<span class="text-danger">Cập nhật tên ảnh thành công</span>');
              }
            });
          });
        
          $(document).on('click','.delete-gal',function(){
              var gal_id = $(this).data('gal_id');
              var _token = $('input[name="_token"]').val();
              if(confirm('Bạn có muốn xóa ảnh này không?')){
                $.ajax({
                url:"{{url('/delete-gallery')}}",
                method: "POST",
                data:{gal_id:gal_id,_token:_token},
                success: function(data){
                  load_gallery();
                  $('#error_gallery').html('<span class="text-danger">Xóa ảnh thành công</span>');
              }
            });
          }              
        });

        $(document).on('change','.file_imgae',function(){
              var gal_id = $(this).data('gal_id');
              var image =  document.getElementById('file-'+gal_id).files[0];
              var form_data = new FormData();
              form_data.append("file", document.getElementById('file-'+ gal_id).files[0]);
              form_data.append("gal_id", gal_id);
              $.ajax({
                url:"{{url('/update-gallery')}}",
                method: "POST",
                headers:{
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success: function(data){
                  load_gallery();
                  $('#error_gallery').html('<span class="text-danger">Cập nhật ảnh thành công</span>');
                }
            });                     
        });

      });
    </script>
    

  </body>
</html>
