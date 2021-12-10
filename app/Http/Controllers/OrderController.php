<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Account;
session_start();

class OrderController extends Controller
{
    public function showOrder()
    {
       $all_order = DB::table('tbl_order')->join('tbl_shipping','tbl_shipping.shipping_id','=','tbl_order.shipping_id')
       ->join('tbl_order_detail','tbl_order_detail.order_id','=','tbl_order.order_id')
       ->orderby('order_date', 'DESC')->paginate(5)->appends(request()->query());
        return view('order.show_order')->with('all_order', $all_order);
    }
    
    public function detailOrder($id)
    {
        
        $detail_order = OrderDetails::where('order_id',$id)->get();
        $order = Order::where('order_id', $id)->get();
        foreach($order as $key => $ord) {
            $account_id = $ord->account_id;
            $shipping_id = $ord->shipping_id;
        }
        $account = Account::where('account_id', $account_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        
        $order_details = OrderDetails::with('product')->where('order_id', $id)->get();
        return view('order.detail_order')->with(compact('detail_order','account','shipping','order_details'));

    }
    
    public function deleteOrder($id)
    {
        $detail_order = DB::table('tbl_order_detail')->where('order_id',$id)->get();
        foreach($detail_order as $key => $ord)
        {
            $productData = array(); 
            $product = DB::table('tbl_product')->where('product_id',$ord->product_id)->first();
             
            $productData['product_quanity'] = $product->product_quanity + $ord->order_product_quanity;
            
            DB::table('tbl_product')->where('product_id',$ord->product_id)->update($productData);
            DB::table('tbl_order_detail')->where('order_detail_id',$ord->order_detail_id)->delete();
        }
        $delete_order = DB::table('tbl_order')->where('order_id',$id)->delete(); 
        Session::put('message','Xóa đơn hàng thành công');
        return redirect('/show-order-admin');
    }

    public function unStatusOrder($id)
    {
        DB::table('tbl_order')->where('order_id', $id)->update(['order_status'=>0]);
        Session::put('message','Đơn hàng đang xử lý');
        return redirect('/show-order-admin');
    }

    public function statusOrder($id)
    {
        DB::table('tbl_order')->where('order_id', $id)->update(['order_status'=>1]);
        Session::put('message','Đơn hàng đã được xử lý');
        return redirect('/show-order-admin');
    }

}
