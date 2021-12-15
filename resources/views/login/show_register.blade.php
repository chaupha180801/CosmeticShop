@extends('frontLayout')
@section('frontEndContent')
<style>
    .errMessage
    {
        color: red;
    }
</style>
<div class="row login">
 <div class="col-lg-6 col-md-6">
       <div class="account_form register">
           <h2>Đăng kí</h2>
           <form action="{{URL::to('/add-customer-account')}}" method="POST">
           {{ csrf_field() }}
                
               <p>   
                   <label>Họ và tên  <span>*</span></label> <br>
                   <input type="text" name="customer_name">
                </p>
                <p>   
                   <label>Emal <span>*</span></label> <br>
                   <input type="email" name="customer_email">
                </p>
                <p>   
                   <label> Số điện thoại  <span>*</span></label> <br>
                   <input type="text" name="customer_phone">
                </p>
                <p>   
                   <label>Mật khẩu  <span>*</span></label> <br>
                   <input type="password" name="customer_password">
                </p>
                <?php
                $message = Session::get('ErrorMessage');
                if ($message)
                {
                    ?>
                        <p class="errMessage">Mật khẩu không khớp, kiểm tra lại</p>
                    <?php
                    Session::put('ErrorMessage','');
                }
               ?>
                <p>   
                   <label>Nhập lại mật khẩu <span>*</span></label> <br>
                   <input type="password" name="customer_re_password">
                </p>
                
               <div class="login_submit">
                   <button type="submit">Đăng kí</button>
               </div>
           </form>
       </div>    
   </div> 
</div>
@endsection