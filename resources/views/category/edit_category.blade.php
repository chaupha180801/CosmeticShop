@extends('admin_layout')
@section('admin_content')
<div class="x_panel">
    <div class="x_title">
        <h2 class="admin_part_heading">Cập nhật danh mục sản phẩm mới </h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
  
    <div class="x_content">
        <br />
       
        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{URL::to('/update-category/'.$edit_category->category_id)}}">
                {{ csrf_field() }}
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="category_product_name">Tên danh mục <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="first-name" required="required" class="form-control "  value="{{$edit_category->category_name}}" name="category_product_name" >
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Mô tả danh mục <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <textarea id="first-name" required="required" class="form-control " cols="30" rows="5" name="category_product_desc">{{$edit_category->category_desc}}</textarea>
                </div>
            </div>
          
            <div class="ln_solid"></div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                    <a class="btn btn-primary" href="{{URL::to('/show-category')}}" type="button">Danh sách danh mục</a>
                </div>
            </div>
        </form>
      
    </div>
</div>
@endsection