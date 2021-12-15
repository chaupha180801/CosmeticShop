<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function index()
    {
        return view('admin_login');
        //echo "abcd";
    }

    public function show_dasdboard()
    {
        $date = getdate();
        
        $search_product = DB::table('tbl_product')
                ->join('tbl_order_detail','tbl_order_detail.product_id','=','tbl_product.product_id')            
                ->selectRaw('sum(tbl_order_detail.order_product_quanity) as soluongban')
                ->groupBy('tbl_product.product_id','tbl_product.product_img','tbl_product.product_quanity',
                'tbl_product.product_name','tbl_product.product_price',
                'tbl_product.product_total_comment','tbl_product.product_total_rating')
                ->orderByDesc('soluongban')
                ->addSelect('tbl_product.product_id','tbl_product.product_img','tbl_product.product_quanity',
                'tbl_product.product_name','tbl_product.product_price',
                'tbl_product.product_total_comment','tbl_product.product_total_rating')
                ->get(5);
        $dtt = DB::table('tbl_order')->whereMonth('order_date', '=' , $date['mon'])->sum('order_total');
        $dtn = DB::table('tbl_order')->whereYear('order_date', '=' , $date['year'])->sum('order_total');
        $total_order = DB::table('tbl_order')->count('order_id');
        $dhxn = DB::table('tbl_order')->where('order_status' , '0')->count('order_id');
        $dhdg = $total_order - $dhxn;
        return view('admin.dashboard')->with('dtt', $dtt)->with('dtn', $dtn)->with('search_product', $search_product)
        ->with('dhxn', $dhxn)->with('dhdg', $dhdg);
        
    }

    public function check_login(Request $request)
    {
        $email = $request->txtUserName;
        $pass = md5($request->txtPass);

        $result = DB::table('tbl_admin')->where('admin_email', $email)->where('admin_pass', $pass)->first();

        if ($result != null)
        {
            Session::put('adminUserName', $result->admin_username);
            Session::put('adminId', $result->admin_id);
            return redirect('/dashboard');

        }
        else {
            Session::put('ErrorMessage', 'Tên đăng nhập hoặc mật khẩu chưa chính xác');
            return redirect('/admin');
        }
    }

    public function logout()
    {
        Session::put('adminUserName','');
        Session::put('adminId', '');
        return redirect('/admin');
    }
}
