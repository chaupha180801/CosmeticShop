<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Storage;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;

use Session;
session_start();

class CheckoutController extends Controller
{
    public function loginCheckout()
    {
        Redirect:: setIntendedUrl(url()->previous());

        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('login.show_login')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function registerCheckout()
    {
        Redirect:: setIntendedUrl(url()->previous());

        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('login.show_register')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function addCustomerAccount(Request $request)
    {
        
        $data = array();
        $data['account_name'] = $request->customer_name;
        $data['account_email'] = $request->customer_email;
        $data['account_password'] = md5($request->customer_password);
        $data['account_phone'] = $request->customer_phone;

        if(($request->customer_password)!=($request->customer_re_password))
        {
            Session::put('ErrorMessage', 'Mật khẩu không khớp');
            return redirect()->back();
        }else{
        $account_id = DB::table('tbl_account')->insertGetId($data);
        Session::put('account_id', $account_id);
        Session::put('account_name', $request->customer_name);
        return redirect()->intended();
        }   
    }

    public function checkOut(){
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('login.checkout')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function saveCheckoutCustomer(Request $request)
    {
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_district'] = $request->shipping_district;
        $data['shipping_province'] = $request->shipping_province;
        $data['shipping_commune'] = $request->shipping_commune;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id', $shipping_id);

        $datapayment = array();
        $datapayment['payment_name'] = $request->check_method;
        $datapayment['payment_status'] = 'Đang chờ xử lí';
        $payment_id = DB::table('tbl_payment')->insertGetId($datapayment);
        //insert order
        $orderData = array();
        $orderData['account_id'] = Session::get('account_id');
        $orderData['shipping_id'] = Session::get('shipping_id');
        $orderData['payment_id'] = $payment_id;
        $orderData['order_date'] = Carbon::now('Asia/Ho_Chi_Minh');
        $orderData['order_total'] = Cart::subtotal();
        $orderData['order_status'] = 'Đang chờ xử lí';
        $order_id = DB::table('tbl_order')->insertGetId($orderData);
        // insert order detail
        $content = Cart::content();
        foreach($content as $v_content){
            $odData = array();
            $odData['order_id'] = $order_id;
            $odData['product_id'] = $v_content->id;
            $odData['product_name'] = $v_content->name;
            $odData['product_price'] = $v_content->price;
            $odData['order_product_quanity'] = $v_content->qty;
            $result = DB::table('tbl_order_detail')->insert($odData);
            
        }
        Cart::destroy();

        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        
        return view('cart.finsh_order')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function logoutCheckout(){
        Session::flush();
      
        return redirect::to('/');
    }

    public function loginAccount(Request $request)
    {
        $email = $request->account_email;
        $password = md5($request->account_password);
        $remember = $request->remember;

        if($remember == 1)
        {
            $request->session()->keep(['account_email', 'account_password']);
        }

        $result = DB::table('tbl_account')->where('account_email', $email)
        ->where('account_password', $password)->first();

        if($result)
        {
            Session::put('account_id', $result->account_id);
            return redirect()->intended('/');
        }else{
            Session::put('ErrorMessage', 'Tên đăng nhập hoặc mật khẩu chưa chính xác');
            return redirect('/login-checkout');
        }       
    }  
    
}