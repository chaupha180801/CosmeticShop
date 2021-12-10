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
        return view('admin.dashboard');
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
