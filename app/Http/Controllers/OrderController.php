<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Storage;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Account;
use PDF;
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
    
    public function printOrder($id){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($id));
        return $pdf->stream();
    }

    public function print_order_convert($id){
        $order_details = DB::table('tbl_order_detail')->where('order_id',$id)->get();
        $order = DB::table('tbl_order')->where('order_id',$id)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->account_id;
            $shipping_id = $ord->shipping_id;
            $discount_id = $ord->discount_id;
        }

        $customer = DB::table('tbl_account')->where('account_id',$customer_id)->first();
        $shipping = DB::table('tbl_shipping')->where('shipping_id',$shipping_id)->first();
        $tp = DB::table('tbl_tinhthanhpho')->where('matp',$shipping->shipping_district)->first();
        $qh = DB::table('tbl_quanhuyen')->where('maqh',$shipping->shipping_province)->first();
        $xptt = DB::table('tbl_xaphuongthitran')->where('xaid',$shipping->shipping_commune)->first();
        $discount = DB::table('tbl_discount')->where('discount_id',$discount_id)->first();

        $output = '';
        $output .='
        <style>
            body{
                font-family: DejaVu Sans;
            }
            .table-styling{
                border:1px solid #000;
            }
            
        </style>
        <h1>CosmeticShop</h1>
        <h4>Địa chỉ: khu phố 6, phường Linh Trung, thành phố Thủ Đức</h4>
        <p>Người đặt hàng</p>
        <table class="table-styling">
                <thead>
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>SĐT</th>
                        <th>Email</th>
                </thead>
                <tbody>';
          
        $output.='
                <tr>
                    <td>'.$customer->account_name.'</td>
                    <td>'.$customer->account_phone.'</td>
                    <td>'.$customer->account_email.'</td>
                </tr>';
            
        $output.='</tbody>
        </table>
        <p>Người nhận</p>
        <table class="table-styling">
                <thead>
                    <tr>
                        <th>Tên người nhận</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Ghi chú</th>
                </thead>
                <tbody>';
          
        $output.='
                <tr>
                    <td>'.$shipping->shipping_name.'</td>
                    <td>'.$shipping->shipping_phone.'</td>
                    <td>'.$shipping->shipping_email.'</td>
                    <td>'.$shipping->shipping_address.','.$xptt->name_commue.','.$qh->name_province.','.$tp->name_city.'</td>
                    <td>'.$shipping->shipping_note.'</td>
                </tr>';
            
        
        $output.='</tbody>
                </table>
                <p>Đơn đặt hàng</p>
                <table class="table-styling">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá sản phẩm</th>
                                <th>Tổng tiền</th>
                        </thead>
                        <tbody>';
                    $subtotal = 0;
                foreach($order_details as $key =>$ord){
                    $total = $ord->order_product_quanity * $ord->product_price;
                    $subtotal +=$total;
                    $output.='
                            <tr>
                                <td>'.$ord->product_name.'</td>
                                <td>'.$ord->order_product_quanity.'</td>
                                <td>'.number_format($ord->product_price,0,',','.').'đ'.'</td>
                                <td>'.number_format($total,0,',','.').'đ'.'</td>
                            </tr>';
                } 
                if($discount){
                    $output.='
                        <tr>
                            <td colspan="2">
                                <p>Mã giảm giá: '.$discount->discount_code.'</p>                               
                                <p>Phí ship:'.number_format(30000,0,',','.').'đ'.'</p>
                                <p>Tổng tiền giảm: '.number_format($subtotal* ($discount->discount_percent/100),0,',','.').'đ'.'</p>
                                <p>Tổng tiền:'.number_format($subtotal*(1 - $discount->discount_percent/100)+30000,0,',','.').'đ'.'</p>
                            </td>
                        </tr>
                        ';
                }else{
                    $output.='
                    <tr>
                        <td colspan="2">                                                  
                            <p>Phí ship:'.number_format(30000,0,',','.').'đ'.'</p>
                            <p>Tổng tiền:'.number_format($subtotal+30000,0,',','.').'đ'.'</p>
                        </td>
                    </tr>
                    ';
                } 
                
                $output.='</tbody>
                        </table>';
                $output.='<p>Cảm ơn quý khách đã ủng hộ shop nhé.</p>';
        return $output;
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
