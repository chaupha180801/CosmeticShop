<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class DiscountController extends Controller
{
    public function showDiscount()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $all_discount = DB::table('tbl_discount')->paginate(5)->appends(request()->query());
            return view('discount.show_discount')->with('all_discount', $all_discount);
        }
    }

    public function create()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            return view('discount.add_discount');
        }
    }

    public function saveDiscount(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $data = array();
            $data['discount_code'] = $request->discount_name;
            $data['discount_desc'] = $request->discount_desc;
            $data['discount_percent'] = $request->discount_percent;
            $data['discount_start'] =  $request->discount_start;
            $data['discount_end'] = $request->discount_end;
            $data['discount_quantity'] = $request->discount_quantity;
            DB::table('tbl_discount')->insert($data);
            Session::put('message', 'Thêm chương trình khuyến mãi thành công');
            return redirect('/show-discount');
        }
    }

    public function editDiscount($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $edit_discount = DB::table('tbl_discount')->where('discount_id', $id)->first();
            $magage_discount = view('discount.edit_discount')->with(compact('edit_discount'));
            return view('admin_layout')->with('discount.edit_discount', $magage_discount);
        }
    }

    public function updateDiscount(Request $request, $id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $data = array();
            $data['discount_code'] = $request->discount_name;
            $data['discount_desc'] = $request->discount_desc;
            $data['discount_percent'] = $request->discount_percent;
            $data['discount_start'] =  $request->discount_start;
            $data['discount_end'] = $request->discount_end;
            $data['discount_quantity'] = $request->discount_quantity;
            DB::table('tbl_discount')->where('discount_id', $id)->update($data);
            Session::put('message', 'Cập nhật khuyến mãi thành công');
            return redirect('/show-discount');
        }
    }

    public function deleteDiscount($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_discount')->where('discount_id', $id)->delete();
            Session::put('message', 'Xóa khuyến mãi thành công');
            return redirect('/show-discount');
        }
    }

    public function getDiscountInfo($code)
    {
            $discount = DB::table('tbl_discount')->where('discount_code', $code)->first();
            if ($discount == NULL) {
                return response('', 404);
            }
            return response()->json($discount);
    }
}
