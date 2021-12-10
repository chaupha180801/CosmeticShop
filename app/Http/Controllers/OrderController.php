<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Storage;
use Gloudemans\Shoppingcart\Facades\Cart;

use Session;
session_start();

class OrderController extends Controller
{
    public function historyOrder()
    {
        if(!Session::get('account_id'))
        {
            return Redirect::to('/login-checkout')->with('error','Vui lòng đăng nhập để xem lịch sử mua hàng!');
        }else{
        
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();

        $account_id = Session::get('account_id');

        $all_orders = DB::table('tbl_order')->where('account_id',$account_id)->orderBy('order_id','DESC')
        ->paginate(4)->appends(request()->query());

        return view('order.history_order')->with('all_orders',$all_orders)
        ->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
        
        }
    }

    public function showPurchaseOrderDetail(Request $request)
    {
        $data = $request->all();
        $order_details = DB::table('tbl_order_detail')->where('order_id', $data['order_id'])->get();
        $output ='';
        $output = '
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
        ';
        $i=0;
        foreach($order_details as $key => $od)
        {
            $i++;
            $output.='
                <tr>
                    <td>'.$i.'</td>
                    <td>
                        <a href="'.url('/chi-tiet-san-pham/'.$od->product_id).'" target = "_blank">'.$od->product_name.'</a>
                    </td>
                    <td>'.$od->product_price.' VNĐ</td>
                    <td>'.$od->order_product_quanity.'</td>
                    <td>'.$od->order_product_quanity * $od->product_price.' VNĐ</td>
                </tr>
            ';
        }
            $output.='
            </tbody>
        </table>
            ';
            return response($output);
        }
    }    
