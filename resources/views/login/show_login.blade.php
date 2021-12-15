@extends('frontLayout')
@section('frontEndContent')
<style>
    .errMessage
    {
        color: red;
    }
</style>
<div class="row login">
    <!--login area start-->
    <!--login area start-->

    <div class="col-md-3"></div>
    <div class="col-lg-6 col-md-6">
       <div class="account_form">
           <h4>Đăng nhập</h4>
           <form action="{{URL::to('login-account')}}" method="POST">
           {{ csrf_field() }}
            <?php
                $message = Session::get('ErrorMessage');
                if ($message)
                {
                    ?>
                        <p class="errMessage">Tên đăng nhập hoặc mật khẩu không đúng, kiểm tra lại</p>
                    <?php
                    Session::put('ErrorMessage','');
                }
            ?>
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
                   <label for="remember">
                       <input id="remember" type="checkbox" name = "remember" value = "1">
                       Remember me
                   </label>
                   <a href="#">Quên mật khẩu?</a>
                   
               </div>

           </form>
        </div>    
   </div>
  
</div>
@endsection
