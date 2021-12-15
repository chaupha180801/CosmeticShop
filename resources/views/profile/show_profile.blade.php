@extends('frontLayout')
@section('frontEndContent')
<div class="container">
    <div class="row" id="new_shipping">
        <div class="overlay_shipping" onclick="overlay_click()">
    
        </div>
        <?php
        $account_id = Session::get('account_id');
        ?>
        <form class="row shipping_content" action="{{URL::to('/save-shipping/'.$account_id)}}" method="POST">
            <i class="far fa-times-circle" onclick="overlay_click()"></i>
            {{ csrf_field() }}
            <h3>Thêm địa chỉ mới</h3>
                <div class="col-md-7 mb-30">
                    <label>Tên người nhận</label>  <span>*</span></label> <br>
                    <input class="input_checkout_infomation" type="text" name="shipping_name">  
                </div>
                <div class="col-lg-5 mb-30">
                    <label>Điện thoại<span>*</span></label> <br>
                    <input class="input_checkout_infomation" type="text" name="shipping_phone">  
                </div> 
                 <div class="col-lg-12 mb-30">
                    <label> Địa chỉ email   <span>*</span></label> <br>
                     <input class="input_checkout_infomation" type="text" name="shipping_email">  
                </div> 
             
                <div class="col-4 mb-30">
                    <label for="country">Tỉnh/thành phố <span>*</span></label> <br>
                    <select name="shipping_district"  class="input_checkout_infomation choose city" id="city"> 
                        <option value="">Chọn tỉnh/thành phố</option> 
                        @foreach($city as $key => $item)
                            <option value="{{$item->matp}}">{{$item->name_city}}</option>
                         @endforeach     
                    </select>
                </div>
    
                <div class="col-4 mb-30">
                    <label for="country">Huyện/thành phố<span>*</span></label> <br>
                    <select name="shipping_province"  class="input_checkout_infomation province choose" id="province"> 
                        <option value="">Chọn huyện/thành phố</option> 
                    </select>     
                </div>
                <div class="col-4 mb-30">
                    <label for="country">Xã/phường<span>*</span></label> <br>
                    <select name="shipping_commune"  class="input_checkout_infomation wards" id="wards"> 
                        <option value="">Chọn xã/phường</option> 
                    </select>    
                </div> 
                 <div class="col-12">
                    <label>Địa chỉ nhà <span>*</span></label> <br>
                    <input class="input_checkout_infomation" type="text" name="shipping_address">    
                </div> 
              
                <div class="col-12">
                    <div class="order-notes">
                         <label for="order_note">Order Notes</label> <br>
                        <textarea id="order_note" placeholder="Ghi chú về giao hàng" class="input_checkout_infomation" rows="5" name="shipping_note"></textarea>
                    </div>    
                </div>     	
                <button type="submit">Lưu</button>    	    	    	    	    	         
            </form>
    </div>
    @foreach ($profile as $key => $item)
    <div class="row" id="new_profile">
        <div class="overlay_profile" onclick="overlayInfo_click()">
    
        </div>
    
        <form class="row profile_content" action="{{URL::to('/update-account-profile/'.$account_id)}}" method="POST">
            <i class="far fa-times-circle" onclick="overlayInfo_click()"></i>
            {{ csrf_field() }}
            <h5 class="edit_profile_heading">Chỉnh sửa thông tin cá nhân</h5>
            <div class="row">
                <div class="col-md-6 input_item">
                    <label>Họ và tên</label> <br>
                    <input type="text" name="update_account_name" id="" value="{{$item->account_name}}" required>
                </div>
                <br>
                <div class="col-lg-6 input_item">
                    <label>Ngày sinh<span>*</span></label> <br>
                    <input type="text" name="update_account_birth" id="" value="{{$item->account_birth}}" required>
                </div> 
                <div class="col-md-6 input_item">
                    <label>Điện thoại</label>  <span>*</span></label> <br>
                    <input type="text" name="update_account_phone" id="" value="{{$item->account_phone}}" required>
                </div>
                <br>
                <div class="col-lg-6 input_item">
                    <label>Email<span>*</span></label> <br>
                    <input type="text" name="update_account_email" id="" value=" {{$item->account_email}}" required>
                </div> 
                <div class="col-md-6 input_item">
                    <label>Nghề nghiệp</label>  <span>*</span></label> <br>
                    <input type="text" name="update_account_job" id="" value="{{$item->account_job}}" required>
                </div>
              <br>
              
                <div class="col-md-12">
                    <div class="order-notes">
                         <label for="order_note">Địa chỉ</label> <br>
                         <input type="text" class="address"  name="update_account_address" value="{{$item->account_address}}" required>
                    </div>    
                </div>     	
            </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Cập nhật</button>    	    	    	    	    	         
            </form>
        </div>
    <div class="breadcums row">
        <ul>
            <li>Home</li>
            <li><i class="fa fa-angle-right"></i></li>
            <li>Thông tin cá nhân</li>
        </ul>
    </div>
    <div class="row profile_row">
      
        <div class="col-md-4 pf">
            <?php
                $account_id = Session::get('account_id');
            ?>
            <div class="profile_image">
                <img src="{{URL::to('public/frontEnd/images/'.$item->account_avatar)}}" alt="" id="img_div">
                
             
            </div>
           
           <form action="{{URL::to('/update_profile/'.$account_id)}}" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                <input type="file" name="avartar" id="profileImg" required onchange="show_profile_img()">
                <label for="profileImg">
                    <i class="fas fa-camera"></i>
                </label>
                <br>
            <p class="name_profile">{{$item->account_name}}</p>
    
                <input type="submit" value="Cập nhật ảnh đại diện" class="btn-sm btn-primary">
            </form>
        </div>
        <div class="col-md-4">
           <div class="profile_content">
               <h4  class="checkout_heading infomat">THÔNG TIN CÁ NHÂN</h4>
               <p><i class="fas fa-birthday-cake"></i>{{$item->account_birth}}</p>
               <p><i class="fas fa-phone"></i> {{$item->account_phone}}</p>
               <p> <i class="fas fa-envelope-square"></i> {{$item->account_email}}</p>
               <p><i class="fas fa-briefcase"></i>{{$item->account_job}}</p>
               <p><i class="fas fa-map-marker"></i>{{$item->account_address}}</p>
               <button class="btn btn-warning" onclick="editInfomation();"><i class="fas fa-edit"></i> Sửa thông tin cá nhân</button>
              
           </div>
        </div>
        <div class="col-md-4">
            
            <h3 class="checkout_heading">Thông tin nhận hàng</h3>
            <?php
                $i = 1;
            ?>
            @foreach ($shipping_list as $key_shipping => $item_shipping)
            <?php
            $i++;
            ?>
            @if ($shipping_list != null)
                <input type="radio" name="shipping_selected" id="{{$i}}" class="radio_shipping" value="{{$item_shipping->shipping_id}}" <?php if ($i ==2) echo "checked='checked'" ?>> 
                <label for="{{$i}}" class="lb_radio">
                    <div class="row">
                        <div class="shipping_item info">
                        
                                <p class="shipping_item_name">{{$item_shipping->shipping_name}}</p>
                                <p class="shipping_item_phone"><i class="fas fa-phone"></i> (+84){{$item_shipping->shipping_phone}}</p>
                                <p class="shipping_item_address"><i class="fas fa-map-marker-alt"></i> {{$item_shipping->shipping_address}} - {{$address[2]}} - {{$address[1]}} - {{$address[0]}}</p>
                                <?php if ($i ==2) echo "<p class='default_shipping'>(Mặc định)</p>" ?>
                        
                            <a href="{{URL::to('/delete-shipping/'.$account_id)}}"> <i class="far fa-times-circle"></i></a>
                        
                        </div>
                    </div>
                </label>
            @else
                <p>Bạn chưa có địa chỉ nào</p>
            @endif
            
            <br>
            @endforeach
            <div class="add_new_shipping infoma" onclick="addShipping()">
                <p>Thêm địa chỉ mới</p>
                <i class="far fa-plus-square"></i>
            </div>
        </div>
       
    </div>
    @endforeach
</div>

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
        new_profile.style.display = "block";
    }
    function overlayInfo_click(){
        new_profile.style.display = "none";
    }

    $(document).ready(function(){ 
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var maid = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            if(action == 'city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url:'{{url('/address')}}',
                method:'POST',
                data:{action:action,maid:maid,_token:_token},
                success:function(data) {
                    $('#'+result).html(data);
                }
            });
        });
    });


    function addShipping(){
        new_shipping.style.display = "block";
    }
    function overlay_click(){
        new_shipping.style.display = "none";
    }
</script>
@endsection


