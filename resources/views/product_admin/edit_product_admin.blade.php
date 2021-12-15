@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <div class="x_title">
        <h2  class="admin_part_heading">Cập nhật sản phẩm </h2>
        <ul class="nav navbar-right panel_toolbox" style="margin-left:100px">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <?php
            $message = Session::get('message');
            if ($message)
            {
                ?>
                    <div class="alert alert-success" role="alert">
                    <?php echo $message; ?>
                    <i class="fa fa-times"></i>
                    </div>
                <?php
                Session::put('message','');
            }
         ?>
        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="{{URL::to('/update-product/'.$edit_product->product_id)}}" method="POST" enctype="multipart/form-data">
        
        {{ csrf_field() }}
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tên sản phẩm <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="first-name" required="required" class="form-control" value ="{{$edit_product->product_name}}" name="product_name">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Hình ảnh sản phẩm</label>      
                <div class="col-md-6 col-sm-6 ">
                    <input type="file" id="first-name"  class="form-control" name="product_image" >
                    <img src="{{asset('public/backEnd/images/'.$edit_product->product_img)}}" height="100" width="100">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Giá sản phẩm <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="last-name" name="product_price" required="required" class="form-control" value ="{{$edit_product->product_price}}"
                    pattern="[0-9]+" title="Giá tiền không hợp lệ">
                </div>
            </div>
            <div class="item form-group">
                <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Số  lượng </label>
                <div class="col-md-6 col-sm-6 ">
                    <input id="middle-name" class="form-control" type="text" name="product_quanity" value ="{{$edit_product->product_quanity}}"
                    pattern="[0-9]+" title="Số tiền không hợp lệ">
                </div>
            </div>
            <div class=" item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Mô tả sản phẩm<span class="required">*</span></label>
                <div class="col-md-9 col-sm-9">
                    <textarea  required="required" name='product_desc' cols="30" rows="5">{{$edit_product->product_desc}}</textarea></div>
            </div>
            <div class="form-group item">
                <label class="control-form-label col-md-3 col-sm-3 label-align" >Danh mục</label>
                <div class="col-md-6 col-sm-6 ">
                    <select name="category_id" class="form-control">

                        @foreach($cate_product as $key =>$muc)
                            <option value="{{$muc->category_id}}" {{ $muc->category_id== $edit_product->category_id ? 'selected' : '' }} >{{$muc->category_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group item">
                <label class="control-form-label col-md-3 col-sm-3 label-align" >Nhãn hiệu</label>
                <div class="col-md-6 col-sm-6 ">
                    <select name ="brand_id" class="form-control">
                    @foreach($brand_product as $key =>$hieu)
                        <option value="{{$hieu->brand_id}}" {{ $hieu->brand_id== $edit_product->brand_id ? 'selected' : '' }} >{{$hieu->brand_name}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group item">
                <label class="control-form-label col-md-3 col-sm-3 label-align" >Nhà cung cấp</label>
                <div class="col-md-6 col-sm-6 ">
                    <select name="supplier_id" class="form-control">
                    @foreach($supplier_product as $key =>$ncc)
                    <option value="{{$ncc->supplier_id}}" {{ $ncc->supplier_id== $edit_product->supplier_id ? 'selected' : '' }} >{{$ncc->supplier_name}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Ngày hết hạn <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" 
                    type="text" name ="product_expire" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" 
                    onblur="this.type='text'" onmouseout="timeFunctionLong(this)" value="{{Carbon\Carbon::parse($edit_product->product_expire)->format('Y-m-d')}}">
                    <script>
                        function timeFunctionLong(input) {
                            setTimeout(function() {
                                input.type = 'text';
                            }, 60000);
                        }
                    </script>
                </div>
            </div>
            <div class="ln_solid"></div>
            
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <button class="btn btn-primary" type="submit">Cập nhật</button>
                    <button class="btn btn-primary" type="reset">Reset</button>
                   <a href="{{URL::to('/show-product-admin')}}" class="btn btn-success">Danh sách sản phẩm</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection