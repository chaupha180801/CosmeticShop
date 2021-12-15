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

    public function show_dasdboard()
    {
        if(!Session::get('adminId'))
        {
            return Redirect::to('/admin')->with('error','Vui lòng đăng nhập!');
        }else{
            return view('admin.dashboard');
        }
       
    }

    public function logout()
    {
        Session::put('adminUserName','');
        Session::put('adminId', '');
        return redirect('/admin');
    }

    public function saveAdmin(Request $request)
    {
        $data = array();
        $data['admin_name'] = $request->adminName;
        $data['admin_username'] = $request->adminName;
        $data['admin_email'] = $request->adminEmail;
        $data['admin_pass'] = md5($request->adminPass);
 
        $admin_id = DB::table('tbl_admin')->insertGetId($data);
        Session::put('adminId', $admin_id);
        Session::put('adminUserName', $request->adminName);
        return redirect('/dashboard');
    }
}
