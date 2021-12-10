@extends('frontLayout')
@section('frontEndContent')
<div class="row login">

    <div class="col-lg-6 col-md-6">
       <div class="account_form">
           <h2>Đăng nhập</h2>
           <form action="{{URL::to('login-account')}}" method="POST">
           {{ csrf_field() }}
               <p>   
                   <label>Email đăng nhập <span>*</span></label> <br>
                   <input type="text" name="account_email" >
                </p>
                <p>   
                   <label>Mật khẩu <span>*</span></label> <br>
                   <input type="password" name="account_password">
                </p>   
               <div class="login_submit">
                   <button type="submit">Đăng nhập</button>
                   <a href="{{URL::to('/register-form')}}">Đăng kí</a>
                   <label for="remember">
                       <input id="remember" type="checkbox">
                       Remember me
                   </label>
                   <a href="#">Quên mật khẩu?</a>
                   
               </div>

           </form>
        </div>    
   </div>
  
</div>

@endsection
