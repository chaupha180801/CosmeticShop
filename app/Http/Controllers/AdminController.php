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
        //doanh thu tháng

        $datas = array(150,200,300,100,230,340,150,250,450,290,30,25);

        return view('admin.dashboard')->with("datas", $datas);
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
            Session::put('adminImg', $result->admin_avatar);

            return redirect('/dashboard');

        }
        else {
            Session::put('ErrorMessage', 'Tên đăng nhập hoặc mật khẩu chưa chính xác');
            return redirect('/admin');
        }
    }

    public function showProfile($id)
    {
        $profile = DB::table('tbl_admin')->where('admin_id', $id)->get();
        return view('profile.show_profileAdmin')->with('profile', $profile);
    }

    public function logout()
    {
        Session::put('adminUserName','');
        Session::put('adminId', '');
        Session::put('adminImg', '');

        return redirect('/admin');
    }

    public function editImageProfile(Request $request,$id)
    {
        $image = $request->file('avatar');
        if($image != NULL){ 
            $path = 'public/backEnd/images';
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move($path, $image_name);
            DB::table('tbl_admin')->where('admin_id',$id)->update(['admin_avatar'=> $image_name]);
            Session::put('adminImg', $image_name);

            return redirect('/profile-admin/'.$id);
        }
    }

    public function updateAdminProfile(Request $request, $id)
    {
        $profile = array();
        $profile['admin_name'] = $request->update_admin_name;
        $profile['admin_username'] = $request->update_admin_username;
        $profile['admin_birth'] = $request->update_admin_birth;
        $profile['admin_phone'] = $request->update_admin_phone;
        $profile['admin_email'] = $request->update_admin_email;
        $profile['admin_address'] = $request->update_admin_address;
        $profile['admin_job'] = $request->update_admin_job;

        DB::table('tbl_admin')->where('admin_id', $id)->update($profile);
        Session::put('message','Cập nhật thông tin cá nhân thành công');
        return redirect('/profile-admin/'.$id);
    }

    public function updateAccountProfile(Request $request, $id)
    {
        $profile = array();
        $profile['account_name'] = $request->update_account_name;
        $profile['account_birth'] = $request->update_account_birth;
        $profile['account_phone'] = $request->update_account_phone;
        $profile['account_email'] = $request->update_account_email;
        $profile['account_address'] = $request->update_account_address;
        $profile['account_job'] = $request->update_account_job;

        DB::table('tbl_account')->where('account_id', $id)->update($profile);
        Session::put('message','Cập nhật thông tin cá nhân thành công');
        return redirect('/profile/'.$id);
    }


    
}
