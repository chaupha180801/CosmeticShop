@extends('frontLayout')
@section('frontEndContent')
<div class="row login">
   <div class="col-sm-3"></div>
 <div class="col-lg-6 col-md-6">
       <div class="account_form register">
           <h5 class="login_header">ĐĂNG KÍ</h5>
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
                <p>   
                   <label>Nhập lại mật khẩu <span>*</span></label> <br>
                   <input type="password" name="customer_password">
                </p>
              
               <div class="login_submit">
                   <button type="submit">Đăng kí</button>
               </div>
           </form>
       </div>    
   </div> 
</div>
@endsection