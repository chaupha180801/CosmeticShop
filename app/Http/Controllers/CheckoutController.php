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

    public function checkOut($id){
        $shipping_list = DB::table('tbl_shipping')->where('account_id', $id)->orderby('shipping_id', 'DESC')->get();
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('login.checkout')->with('brand', $thuonghieu)->with('supplier', $nhacungcap)->with('shipping_list', $shipping_list);
    }

    public function saveCheckoutCustomer(Request $request){
       
        $shipping_id = $request->shipping_selected;
        Session::put('shipping_id', $shipping_id);

        $datapayment = array();
        $datapayment['payment_name'] = $request->check_method;
        $datapayment['payment_status'] = 'Đang chờ xử lí';
        $payment_id = DB::table('tbl_payment')->insertGetId($datapayment);
        //insert order
        $orderData = array();
        $orderData['account_id'] = Session::get('account_id');
        $orderData['shipping_id'] = Session::get('shipping_id');
        $orderData['shipping_id'] = Session::get('shipping_id');
        $orderData['order_date'] = Carbon::now('Asia/Ho_Chi_Minh');
        $orderData['discount_id'] = $request->discount;            
        $orderData['payment_id'] = $payment_id;
        $orderData['order_total'] = $request->cart_total;
        $orderData['order_status'] = 'Đang chờ xử lí';
        $order_id = DB::table('tbl_order')->insertGetId($orderData);
        // insert order detail
        $content = Cart::content();
        foreach($content as $v_content){
            $orderDetaildData = array();
            $orderDetaildData['order_id'] = $order_id;
            $orderDetaildData['product_id'] = $v_content->id;
            $orderDetaildData['product_name'] = $v_content->name;
            $orderDetaildData['product_price'] = $v_content->price;
            $orderDetaildData['order_product_quanity'] = $v_content->qty;
            DB::table('tbl_order_detail')->insert($orderDetaildData);  
            
            $product = DB::table('tbl_product')->where('product_id', $v_content->id)->first();
            $productData = array();
            $productData['product_quanity'] = $product->product_quanity - $v_content->qty;
            DB::table('tbl_product')->where('product_id', $v_content->id)->update($productData);
        }
        if($request->discount != NULL){
            $discountData = array();
            $discountData['discount_quantity'] = $request->discount_quantity - 1;
            DB::table('tbl_discount')->where('discount_id', $request->discount)->update($discountData);
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
        return Redirect::to('/');
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
            Session::put('account_name', $result->account_name);
            Session::put('account_img', $result->account_avatar);
            return redirect()->intended('/');
        }else{
            Session::put('ErrorMessage', 'Tên đăng nhập hoặc mật khẩu chưa chính xác');
            return redirect('/login-checkout');
        }       
    }  

    public function saveShipping(Request $request, $id){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_district'] = $request->shipping_district;
        $data['shipping_province'] = $request->shipping_province;
        $data['shipping_commune'] = $request->shipping_commune;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;
        $data['account_id'] = $id;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id', $shipping_id);
        return Redirect::to('checkout/'.$id);
    }

    public function showProfile($id){
        $profile = DB::table('tbl_account')->where('account_id', $id)->get();
        $shipping_list = DB::table('tbl_shipping')->where('account_id', $id)->get();
       
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('profile.show_profile')->with('brand', $thuonghieu)->with('supplier', $nhacungcap)->with('shipping_list', $shipping_list)->with('profile', $profile);
    }

    public function saveImage($image){
        $path = 'public/backEnd/images';
        $image_name = $image->getClientOriginalName();
        $image_name = current(explode('.', $image_name));
        $new_image_name = $image_name.rand(0,99).'.'.$image->getClientOriginalExtension();
        $image->move($path, $new_image_name);
        return $new_image_name;
    }

    
    public function updateProfile(Request $request,$id)
    {
        $image = $request->file('avartar');
        if($image != NULL){ 
            $path = 'public/frontEnd/images';
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move($path, $image_name);
            DB::table('tbl_account')->where('account_id',$id)->update(['account_avatar'=> $image_name]);
            Session::put('account_img', $image_name);

            return redirect('/profile/'.$id);
        }
    }


}

