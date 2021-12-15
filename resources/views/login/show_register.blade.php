@extends('frontLayout')
@section('frontEndContent')
<style>
    .errMessage
    {
        color: red;
    }
</style>
<div class="row login">
    <div class="col-md-3"></div>
 <div class="col-lg-6 col-md-6">
       <div class="account_form register">
           <h4>Đăng kí</h4>
           <form action="{{URL::to('/add-customer-account')}}" method="POST">
           {{ csrf_field() }}
                
               <p>   
                   <label>Họ và tên  <span>*</span></label> <br>
                   <input type="text" name="customer_name">
                </p>
                <p>   
                   <label>Email <span>*</span></label> <br>
                   <input type="email" name="customer_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" title="Email không hợp lệ." >
                </p>
                <p>   
                   <label> Số điện thoại  <span>*</span></label> <br>
                   <input type="text" name="customer_phone"
                   pattern="[0]{1}[0-9]{9}" title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số.">
                </p>
                <p>   
                   <label>Mật khẩu  <span>*</span></label> <br>
                   <input type="password" name="customer_password"
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Mật khẩu phải có ít nhất kí tự hoa,thường,ít nhất 1 chữ số và ít nhất là 8 kí tự.">
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