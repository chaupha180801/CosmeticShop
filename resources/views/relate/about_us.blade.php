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

<div class="container au">
    <div class="row">
        <div class="col-md-6">
            <div class="top-left">
                <h3>What is the <span>beaty group</span> ?</h3>
                <h5>What we do</h5>
                <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and
                     I will give you a complete account of the system</p>
                <p>Expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, 
                    dislikes, or avoids pleasure itself, because it is pleasure</p>
                <p>those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="top-right">
                <img src="{{asset('public/frontEnd/images/about4.jpg')}}" alt="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 offset-md-1">
            <div class="center-left">
                <img src="{{asset('public/frontEnd/images/about2.jpg')}}" alt="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="center-right">
                <img src="{{asset('public/frontEnd/images/logo2.png')}}" alt="">
                <h3>Our <span>Method</span></h3>
                <h5>How we do</h5>
                <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and
                     I will give you a complete account of the system</p>
                <p>Expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, 
                    dislikes, or avoids pleasure itself, because it is pleasure</p>
            
               <p>those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="bottom-left">
                <img src="{{asset('public/frontEnd/images/logo1.png')}}" alt="">
                <h3>Our <span> Mission</span></h3>
                <h5>Why we do </h5>
                <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and
                     I will give you a complete account of the system. Expound the actual teachings of the great explorer of the truth.</p>
              
                <p>those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</p>
                <p><strong>Expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, 
                    dislikes, or avoids pleasure itself, because it is pleasureBut I must explain to you how all this mistaken idea
                  </strong>
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bottom-right">
                <img src="{{asset('public/frontEnd/images/about3.jpg')}}" alt="">
            </div>
        </div>
    </div>
</div>
</div>
@endsection