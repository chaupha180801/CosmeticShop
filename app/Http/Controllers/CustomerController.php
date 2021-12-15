<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class CustomerController extends Controller
{
    public function showCustomer()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $all_customer = DB::table('tbl_account')->paginate(5)->appends(request()->query());
            return view('customer.show_customer_admin')->with('all_customer', $all_customer);
        }
    }

    public function addCustomer()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            return view('customer.add_customer');
        }
    }

    public function saveCustomer(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $data = array();
            $data['account_name'] = $request->account_name;
            $data['account_email'] = $request->account_email;
            $data['account_password'] = md5($request->account_password);
            $data['account_phone'] = $request->account_phone;

            DB::table('tbl_account')->insert($data);
            Session::put('message', 'Thêm thông tin khách hàng thành công');
            return redirect('/add-customer');
        }
    }

    public function editCustomer($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $edit_customer = DB::table('tbl_account')->where('account_id', $id)->first();
            $manage_customer = view('customer.edit_customer')->with('edit_customer', $edit_customer);
            return view('admin_layout')->with('customer.edit_customer', $manage_customer);
        }
    }

    public function updateCustomer(Request $request, $id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $customer = array();
            $customer['account_name'] = $request->account_name;
            $customer['account_email'] = $request->account_email;
            $customer['account_phone'] = $request->account_phone;
            DB::table('tbl_account')->where('account_id', $id)->update($customer);
            Session::put('message', 'Cập nhật thông tin khách hàng thành công');
            return redirect('/show-customer-admin');
        }
    }

    public function deleteCustomer($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $delete_customer = DB::table('tbl_account')->where('account_id', $id)->delete();
            Session::put('message', 'Xóa thông tin khách hàng thành công');
            return redirect('/show-customer-admin');
        }
    }

    public function searchCustomerAdmin(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $timkiem = $request->tukhoacustomer;
            $khachhang = DB::table('tbl_account')->where('account_name', 'like', '%' . $timkiem . '%')
                ->orderBy('account_id', 'ASC')->get();
            return view('customer.search_customer')->with('customer', $khachhang);
        }
    }
}
