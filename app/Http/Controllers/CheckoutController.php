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
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('login.show_login')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function registerCheckout(){
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('login.show_register')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function addCustomerAccount(Request $request){
        $data = array();
        $data['account_name'] = $request->customer_name;
        $data['account_email'] = $request->customer_email;
        $data['account_password'] = md5($request->customer_password);
        $data['account_phone'] = $request->customer_phone;
        $account_id = DB::table('tbl_account')->insertGetId($data);
        Session::put('account_id', $account_id);
        Session::put('account_name', $request->customer_name);
        return Redirect('/checkout');
    }

    public function checkOut(Request $request){
        $discount_code = $request->discount_code;
        $discount = DB::table('tbl_discount')->where('discount_code', $discount_code)->first();
        $city = DB::table('tbl_tinhthanhpho')->orderBy('matp','ASC')->get();
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('login.checkout')->with('brand', $thuonghieu)->with('supplier', $nhacungcap)
        ->with('discount', $discount)->with('city',$city);
    }

    public function saveCheckoutCustomer(Request $request){
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
        $datapayment['payment_name'] = 1;
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

    public function loginAccount(Request $request){
        $email = $request->account_email;
        $password = md5($request->account_password);
        $result = DB::table('tbl_account')->where('account_email', $email)
        ->where('account_password', $password)->first();
        if($result){
            Session::put('account_id', $result->account_id);
            return Redirect::to('/');
        }else{
            return Redirect::to('login-checkout');
        }       
    }  

    public function selectAddress(Request $request){
        $data = $request->all();
        if($data['action']){
            if($data['action'] == "city"){
                $output='';
                $select_province = DB::table('tbl_quanhuyen')->where('matp', $data['maid'])
                ->orderBy('maqh','ASC')->get();
                $output.='<option>---Chọn huyện/thành phố---</option>';
                foreach($select_province as $key =>$province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_province.'</option>';
                }              
            }else{
                $output='';
                $select_wards = DB::table('tbl_xaphuongthitran')->where('maqh', $data['maid'])
                ->orderBy('xaid','ASC')->get();              
                $output.='<option>---Chọn xã/phường---</option>';
                foreach($select_wards as $key =>$ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_commue.'</option>';
                }
            }
        }
        return response($output); 
    } 

    public function purchaseHistory(){
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        $account_id = Session::get('account_id');
        $all_orders = DB::table('tbl_order')->where('account_id',$account_id)
        ->paginate(4)->appends(request()->query());
        return view('purchase_history.history_order')->with('all_orders',$all_orders)
        ->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    
}