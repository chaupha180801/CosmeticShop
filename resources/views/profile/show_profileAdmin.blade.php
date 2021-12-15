@extends('admin_layout')
@section('admin_content')
@foreach ($profile as $key => $item)
<div class="row" id="new_shipping">
    <div class="overlay_shipping" onclick="overlay_click()">

    </div>
    <?php
   
    $admin_id = Session::get('adminId');

    ?>
      
    <form class="row shipping_content" action="{{URL::to('/update-admin-profile/'.$admin_id)}}" method="POST">
        <i class="far fa-times-circle" onclick="overlay_click()"></i>
        {{ csrf_field() }}
        <h5 class="edit_profile_heading">Chỉnh sửa thông tin cá nhân</h5>
            <div class="col-md-6 input_item">
                <label>Họ và tên</label> <br>
                <input type="text" name="update_admin_name" id="" value="{{$item->admin_name}}" required>
            </div>
            <div class="col-lg-6 input_item">
                <label>Tên đăng nhập<span>*</span></label> <br>
                <input type="text" name="update_admin_username" id="" value="{{$item->admin_username}}" required>
            </div> 
            <div class="col-lg-6 input_item">
                <label>Ngày sinh<span>*</span></label> <br>
                <input type="text" name="update_admin_birth" id="" value="{{$item->admin_birth}}" required>
            </div> 
            <div class="col-md-6 input_item">
                <label>Điện thoại</label>  <span>*</span></label> <br>
                <input type="text" name="update_admin_phone" id="" value="{{$item->admin_phone}}" required>
            </div>
            <div class="col-lg-6 input_item">
                <label>Email<span>*</span></label> <br>
                <input type="text" name="update_admin_email" id="" value="{{$item->admin_email}}" required>
            </div> 
            <div class="col-md-6 input_item">
                <label>Nghề nghiệp</label>  <span>*</span></label> <br>
                <input type="text" name="update_admin_job" id="" value="{{$item->admin_job}}" required>
            </div>
          
          
            <div class="col-md-12">
                <div class="order-notes">
                     <label for="order_note">Địa chỉ</label> <br>
                     <input type="text" class="address"  name="update_admin_address" value="{{$item->admin_address}}" required>
                </div>    
            </div>     	
            <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Cập nhật</button>    	    	    	    	    	         
        </form>
</div>
<div class="row profile_row">
    <div class="col-md-4 pf">

        <div class="profile_image">
            <img src="{{URL::to('public/backEnd/images/'.$item->admin_avatar)}}" alt="" id="img_div">
            
         
        </div>
       
       <form action="{{URL::to('/update-image-admin/'.$admin_id)}}" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <input type="file" name="avatar" id="profileImg" required onchange="show_profile_img()">
            <label for="profileImg">
                <i class="fas fa-camera"></i>
            </label>
            <br>
        <p class="name_profile">{{$item->admin_name}}</p>

            <input type="submit" value="Cập nhật ảnh đại diện" class="btn-sm btn-primary">
        </form>
    </div>
    <div class="col-md-8">
       <div class="profile_content">
           <h4>THÔNG TIN CÁ NHÂN</h4>
       
           <p>Tên đăng nhập :{{$item->admin_username}}</p>
           <p><i class="fas fa-birthday-cake"></i>{{$item->admin_birth}}</p>
           <p><i class="fas fa-phone"></i>{{$item->admin_phone}}</p>
           <p> <i class="fas fa-envelope-square"></i>{{$item->admin_email}} </p>
           <p><i class="fas fa-briefcase"></i>{{$item->admin_job}}</p>
           <p><i class="fas fa-map-marker"></i>{{$item->admin_address}}</p>

     <button class="btn btn-primary" onclick="editInfomation();">Sửa thông tin cá nhân</button>
         
          
       </div>
    </div>
  
</div>
@endforeach
<script>
    function show_profile_img(){
        const file = profileImg.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener("load", function() {
                    img_div.setAttribute("src", this.result)
                });
                reader.readAsDataURL(file);
            }
    }

    function editInfomation(){
        new_shipping.style.display = "block";
    }
    function overlay_click(){
        new_shipping.style.display = "none";
    }
</script>s
@endsection