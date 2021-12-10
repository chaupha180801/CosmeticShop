@extends('frontLayout')
@section('frontEndContent')
<div class="breadcums row">
    <ul>
        <li>Home</li>
        <li><i class="fa fa-angle-right"></i></li>
        <li>Thông tin cá nhân</li>
    </ul>
</div>
<div class="row">
    @foreach ($profile as $key => $item)
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

            <input type="submit" value="Cập nhật" class="btn-sm btn-primary">
        </form>
    </div>
    <div class="col-md-8">
       <div class="profile_content">
           <h4>THÔNG TIN CÁ NHÂN</h4>
       
           <p>Tên : {{$item->account_name}} </p>
           <p><i class="fas fa-phone"></i> {{$item->account_phone}}</p>
           <p> <i class="fas fa-envelope-square"></i> {{$item->account_email}}</p>
           <button class="btn btn-primary">Sửa thông tin cá nhân</button>
         
          
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
</script>
@endsection

