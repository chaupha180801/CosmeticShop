@extends('frontLayout')
@section('frontEndContent')
<div class="container-fluid">
    <div class="row slide">
        <div class="col-sm-12 main_slide">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('public/frontEnd/images/slide_9.png')}}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            {{-- <h5 class="slide_header">Big Christmas Sale</h5>
                            <p class="slide_desc">Some representative placeholder content for the first slide.</p> --}}
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('public/frontEnd/images/slide_2.jpg')}}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            {{-- <h5 class="slide_header">Black Friday Sale up 70%</h5>
                            <p class="slide_desc">Some representative placeholder content for the second slide.</p> --}}
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('public/frontEnd/images/slide_3.jpg')}}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            {{-- <h5 class="slide_header">Super Sale Black Friday</h5>
                            <p class="slide_desc">Some representative placeholder content for the third slide.</p> --}}
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    
    </div>
    <!-- end slide and sub image -->
 </div>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            {{-- <div> --}}
                <div class="header_sv">
                    <h4 class="service_heading">Tại sao phải chọn Beaty Group?</h4>
                </div>
              <div class="row">
                  <div class="col-md-1">
                    <img src="{{asset('public/frontEnd/images/logo_notext1.png')}}" id="logo_service" alt="">
                  </div>
                  <div class="col-md-11">
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
                        The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, 
                        content here
                        </p>
                  </div>
              </div>
              
                    <p style="font-weight: bold;">Câu hỏi thường gặp:</p>
                    <ul>
                        <li>ôi mua hàng rồi, không vừa ý có thể đổi lại hay không?</li>
                        <li>Tôi đã đặt hàng, giờ muốn hủy đơn hàng phải làm sao?</li>
                        <li>Tôi có được trả hàng nếu tôi không hài lòng với sản phẩm tôi nhận được?</li>
                    </ul>
                <div class="row">
                    <div class="col-md-3 service_overview">
                        <div class="each_service">
                            <i class="fas fa-exchange-alt"></i>
                            <p>Đổi trả</p>
                        </div>
                    </div>
                    <div class="col-md-3 service_overview">
                        <div class="each_service">
                            <i class="fas fa-shipping-fast"></i>
                            <p>Vận chuyển</p>
                        </div>
                    </div>
                    <div class="col-md-3 service_overview">
                        <div class="each_service">
                            <i class="fas fa-question-circle"></i>
                            <p>Chăm sóc khách hàng</p>
                        </div>
                    </div>
                    <div class="col-md-3 service_overview">
                        <div class="each_service">
                            <i class="fas fa-question-circle"></i>
                            <p>Bảo hành lâu dài</p>
                        </div>
                    </div>
                </div>
               
            {{-- </div> --}}
        </div>
        <div class="col-md-4 contribute">
            <form action="">
                <div class="header_sv">
                    <h4 class="service_heading">ĐÓNG GÓP Ý KIẾN</h4>
                </div>
              
                <input type="text" placeholder="họ và tên"> <br>
                <input type="text" placeholder="email"> <br>
                <input type="text" placeholder="số điện thoại"> <br>
                <textarea name="" id="" cols="30" rows="5" placeholder="nội dung đóng góp"></textarea>
                <br>
                <input type="submit" class="btn btn-primary" value="Gửi đóng góp">
            </form>
        </div>
    </div>

    <div class="row doitra">
        <div class="col-md-12">
            <div class="header_sv">
                <h4 class="service_heading">CHÍNH SÁCH ĐỔI TRẢ</h4>
            </div>
          
            <p class="doitra_desc">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over
                 2000 years old. Richard McClintock, a Latin professor 
                 at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur</p>
        </div>
        <div class="col-md-12">
            <h5>Ba bước đổi trả đơn giản</h5>
        </div>
        <div class="col-md-4 doitra_step">
            <i class="far fa-comments first"></i>
            <p>Phản hồi trên fanpage hoặc gọi hotline tới số 034556449 để được tư vấn chi tiết</p>
        </div>
        <div class="col-md-4 doitra_step">
            <i class="fas fa-box-open second"></i>
            <p>Đóng góp sản phẩm kèm thông tin kiện hàng</p>
        </div>
        <div class="col-md-4 doitra_step">
            <i class="fas fa-share-square thirth"></i>
            <p>Gửi hàng về địa chỉ 355 Đỗ Xuân Hợp quận 9 Thành phố Hồ Chí Minh</p>
        </div>

    </div>
    <div class="row shipping">
        <div class="header_sv">
            <h4 class="service_heading">Quá trình vận chuyển</h4>
        </div>
       
        <div class="col-md-4 shipping_img">
            <img src="{{asset('public/frontEnd/images/shipper.png')}}" alt="">
        </div>
        <div class="col-md-8">
            <div class="row sub_ship">
               
    
                <div class="col-md-11 offset-md-1">
                    <p>Bước 1: Gửi yêu cầu giao hàng </p>
                    <p>Quý khách có thể thực hiện 1 trong 2 cách sau để yêu cầu đến nhận hàng và giao đến nơi cần giao: </p>
                        <ul>
                            <li>Gọi điện thoại trực tiếp đến số hotline </li>
                            <li>Tự mình đăng ký tài khoản trên trang và tiến hành tạo vận đơn. Sau khi tạo vận đơn, đội ngũ nhân viên tư vấn sẽ gọi điện đến quý khách để xác nhận đơn hàng</li>
                            <li>Công ty chỉ nhận hàng khi đơn hàng được tạo trên hệ thống với đầy đủ thông tin (Địa chỉ giao nhận phải bao gồm đầy đủ: số nhà, đường, phường, quận).</li>
                        </ul>
                </div>
               
             </div>
            <div class="row sub_ship">
              
                   
                    <div class="col-md-11 offset-md-1">
                        <p>Bước 2: Nhận hàng tận nơi</p>
                        <ul>
                            <li>Khi công ty đã nhận được thông tin về vận đơn của quý khách, nhân viên điều phối sẽ gọi điện cho bạn để xác nhận lại thông tin lấy hàng</li>
                            <li>Khi quý khách đã xác nhận thành công, nhân viên điều phối  sẽ cử nhân viên giao hàng trực tiếp đến nhận hàng của quý khách.</li>
                            <li>Nhân viên giao hàng đến tận nhà  quý khách  để lấy hàng.   Sau đó hàng hóa của quý khách sẽ được mang về kho và quản lý theo từng gói dịch vụ của công ty đã quy định</li>
                        </ul>
                    </div>
                   
                </div>
            <div class="row sub_ship">
               
               
                <div class="col-md-11 offset-md-1">
                    <p>Bước 3: Giao hàng cho khách hàng</p>
                </div>
              
            </div>
        </div>
    </div>

</div>

<div class="container-fluid">
    <div class="row map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22490.94611356003!2d106.7629115893542!3d10.820964767863158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527d4e7f051c1%3A0x5eaa32a7dd4f2b54!2sYaMe.vn!5e0!3m2!1sen!2s!4v1639407635423!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>
@endsection