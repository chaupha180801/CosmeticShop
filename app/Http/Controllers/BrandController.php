<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class BrandController extends Controller
{
    public function showBrand()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $all_brand = DB::table('tbl_brand')->paginate(5)->appends(request()->query());
            return view('brand.show_brand')->with('all_brand', $all_brand);
        }
    }

    public function addBrand()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            return view('brand.add_brand');
        }
    }

    public function saveBrand(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $data = array();
            $data['brand_name'] = $request->brand_name;
            $data['brand_desc'] = $request->brand_desc;
            $data['brand_status'] = $request->brand_status;

            DB::table('tbl_brand')->insert($data);
            Session::put('message', 'Thêm nhãn hiệu phẩm thành công');
            return redirect('/add-brand');
        }
    }

    public function unDisplayBrand($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_brand')->where('brand_id', $id)->update(['brand_status' => 0]);
            Session::put('message', 'Bạn đã ẩn nhãn hiệu thành công');
            return redirect('/show-brand');
        }
    }

    public function displayBrand($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_brand')->where('brand_id', $id)->update(['brand_status' => 1]);
            Session::put('message', 'Bạn đã kích hoạt nhãn hiệu thành công');
            return redirect('/show-brand');
        }
    }


    public function editBrand($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $edit_brand = DB::table('tbl_brand')->where('brand_id', $id)->first();
            $magage_brand = view('brand.edit_brand')->with('edit_brand', $edit_brand);
            return view('admin_layout')->with('brand.edit_brand', $magage_brand);
        }
    }

    public function updateBrand(Request $request, $id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $brand = array();
            //$brand['brand_id'] = $id;
            $brand['brand_name'] = $request->brand_name;
            $brand['brand_desc'] = $request->brand_desc;
            //$brand->save();
            DB::table('tbl_brand')->where('brand_id', $id)->update($brand);
            Session::put('message', 'Cập nhật nhãn hiệu phẩm thành công');
            return redirect('/show-brand');
        }
    }

    public function deleteBrand($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $delete_product = DB::table('tbl_product')->where('brand_id', $id)->delete();
            $delete_brand = DB::table('tbl_brand')->where('brand_id', $id)->delete();
            Session::put('message', 'Xóa nhãn hiệu sản phẩm thành công');
            return redirect('/show-brand');
        }
    }

    public function searchBrandAdmin(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $timkiem = $request->tukhoabrand;
            $thuonghieu = DB::table('tbl_brand')->where('brand_name', 'like', '%' . $timkiem . '%')
                ->orderBy('brand_id', 'ASC')->get();
            return view('brand.search_brand')->with('brand', $thuonghieu);
        }
    }

    public function DetailBrand($id)
    {
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $product = DB::table('tbl_product')->where('brand_id', $id)->take(4)->get();
        return view('relate.brand_detail')->with('product', $product)->with('brand', $thuonghieu);
    }
}
