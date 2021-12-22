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
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $all_order = DB::table('tbl_order')->join('tbl_shipping', 'tbl_shipping.shipping_id', '=', 'tbl_order.shipping_id')
                ->orderby('order_date', 'DESC')->paginate(6)->appends(request()->query());
            return view('order.show_order')->with('all_order', $all_order);
        }
    }
    
    public function printOrder($id){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($id));
        return $pdf->stream();
    }

    public function print_order_convert($id){
        $order_details = DB::table('tbl_order_detail')->where('order_id',$id)->get();
        $quanity = 0;
        foreach($order_details as $key1 => $ord1){
            $quanity += $ord1->order_product_quanity;
        }
        $order = DB::table('tbl_order')->where('order_id',$id)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->account_id;
            $shipping_id = $ord->shipping_id;
            $discount_id = $ord->discount_id;
            $total_order = $ord->order_total;
        }

        $customer = DB::table('tbl_account')->where('account_id',$customer_id)->first();
        $shipping = DB::table('tbl_shipping')->where('shipping_id',$shipping_id)->first();
        $tp = DB::table('tbl_tinhthanhpho')->where('matp',$shipping->shipping_district)->first();
        $qh = DB::table('tbl_quanhuyen')->where('maqh',$shipping->shipping_province)->first();
        $xptt = DB::table('tbl_xaphuongthitran')->where('xaid',$shipping->shipping_commune)->first();
        $discount = DB::table('tbl_discount')->where('discount_id',$discount_id)->first();

        $output = '';

        $output .= '
       
            <style>
            body {
                font-family: DejaVu Sans;
                font-size: 10px
            }
                .invoice_wrap{
                    border: 1px solid gray;
                }
        
                .invoice_head,
                .address,
                .invoice_content,
                .invoice_result {
                  
                    border-bottom: 3px dotted gray;
                    padding: 0 10px;
                }
                 .invoice_result {
                     height : 200px;
                 }
                .address {
                    height: 100px;
                }
        
                .invoice_result_right {
                    text-align: center;
                    margin-top: 20px;
                }
        
                .signature {
                    padding: 10px;
                }

                .invoice_head {
                    height: 100px
                }
        
                .invoice_head h1 {
                   float: left;
                   height: 100px;
                   margin: 0;
                   line-height: 50px;
                   font-size: 30px;
                   color: rgb(248, 103, 127);
                   text-align: center;
                }
                .invoice_head .headerInvoice p {
                    margin: 0;
                    font-weight: bold;
                }
                .invoice_head .headerInvoice {
                    text-align: center;
                    margin-top: 20px;
                }
                .address .from {
                   width: 280px;
                   float: left;
                   margin-right: 30px;
                }
                .address .to {
                    flex: 6;
                }
                .each_item_invoice {
                    min-height: 200px
                }

               
                .invoice_result_left {
                    float: left;
                }

                .invoice_footer p {
                    margin: 10px 
                }
                
            </style>
       
            <div class="invoice_wrap">
                <div class="invoice_head">
                    <h1>BeautyGroup</h1>
                    <div class="headerInvoice">
                        <img src="" alt="">
                        <p>Mã vận đơn: 790kj8990h345js</p>
                        <p>Đơn vị vận chuyển: Giao hàng tiết kiệm</p>
                        <p>Mã đơn hàng: 1780998r89KHNGF899w</p>
                    </div>
                </div>
                <div class="address">
                    <div class="from">
                        <span>Từ</span> <br>
                        <span>Cửa hàng mỹ phẩm beautyGroup</span> <br>
                        <span>Địa chỉ: 50/32b đường 79 khu phố 3 phường Phước Long B, Quận 9</span> <br>
                        <span>SDT: 0354575436</span>
                    </div>
                    <div class="to">
                        <strong>
                        <span>Đến</span> <br>
                        <span>'.$shipping->shipping_name.'</span> <br>
                        <span>Địa chỉ: '.$shipping->shipping_address.','.$xptt->name_commue.','.$qh->name_province.','.$tp->name_city.'</span> <br>
                        <span>SDT: 0'.$shipping->shipping_phone.'</span>
                    </strong>
                    </div>
                </div>
                <div class="invoice_content">
                    <strong>
                        <p>Nội dung hàng <i?>  (tổng cộng:'.$quanity.' ) </i></p>
                        <div class="each_item_invoice">';
                        $subtotal = 0;
                        foreach($order_details as $key =>$ord){
                                        $total = $ord->order_product_quanity * $ord->product_price;
                                        $subtotal +=$total;
                                        $output.='
                                        <span>- '.$ord->product_name.' .SLx'.$ord->order_product_quanity.'</span> <br>';
               
                        } 
                         $output.='
                        </div>
                        <i>Một số sản phẩm có thể mất do hóa đơn quá dài</i>
                    </strong>
                </div>
                <div class="invoice_result">
                    <div class="invoice_result_left">
                        <p>Tiền thu người nhận:</p>
                        <h1>'. $total_order.' VNĐ</h1>
                        <strong>Chỉ dẫn giao hàng: <br>
                        - Không đồng kiểm <br>
                        - Chuyển hoàn sau 3 lần phát <br>
                        - Lưu kho tối đa 5 ngày</strong>
                    </div>
                    <div class="invoice_result_right">
                        <strong><i>Khối lượng tối đa: 200g</i></strong>
                        <div class="signature">
                            <strong>Nhân viên kí nhận hàng</strong> <br>
                            <i>(Kí và ghi rõ họ tên)</i>
                        </div>
                    </div>
                   
                </div>
                <div class="invoice_footer">
                        <p>Cảm ơn quý khác đã ửng hộ shop, hẹn gặp lại lần sau</p>
                </div>
        
            
            </div>
      
        ';

        // $output .='
        // <style>
        //     body{
        //         font-family: DejaVu Sans;
        //     }
        //     .table-styling{
        //         border:1px solid #000;
        //         width: 100%;
        //     }
            
        // </style>
        // <h1 style="text-align: center;">CosmeticShop</h1>
        // <h4  style="text-align: center;">Địa chỉ: khu phố 6, phường Linh Trung, thành phố Thủ Đức</h4>
        // <p>Người đặt hàng</p>
        // <table class="table-styling">
        //         <thead>
        //             <tr>
        //                 <th>Tên khách hàng</th>
        //                 <th>SĐT</th>
        //                 <th>Email</th>
        //         </thead>
        //         <tbody>';
          
        // $output.='
        //         <tr>
        //             <td>'.$customer->account_name.'</td>
        //             <td>'.$customer->account_phone.'</td>
        //             <td>'.$customer->account_email.'</td>
        //         </tr>';
            
        // $output.='</tbody>
        // </table>
        // <p>Người nhận</p>
        // <table class="table-styling">
        //         <thead>
        //             <tr>
        //                 <th>Tên người nhận</th>
        //                 <th>SĐT</th>
        //                 <th>Email</th>
        //                 <th>Địa chỉ</th>
        //                 <th>Ghi chú</th>
        //         </thead>
        //         <tbody>';
          
        // $output.='
        //         <tr>
        //             <td>'.$shipping->shipping_name.'</td>
        //             <td>'.$shipping->shipping_phone.'</td>
        //             <td>'.$shipping->shipping_email.'</td>
        //             <td>'.$shipping->shipping_address.','.$xptt->name_commue.','.$qh->name_province.','.$tp->name_city.'</td>
        //             <td>'.$shipping->shipping_note.'</td>
        //         </tr>';
            
        
        // $output.='</tbody>
        //         </table>
        //         <p>Đơn đặt hàng</p>
        //         <table class="table-styling">
        //                 <thead>
        //                     <tr>
        //                         <th>Tên sản phẩm</th>
        //                         <th>Số lượng</th>
        //                         <th>Giá sản phẩm</th>
        //                         <th>Tổng tiền</th>
        //                 </thead>
        //                 <tbody>';
        //             $subtotal = 0;
        //         foreach($order_details as $key =>$ord){
        //             $total = $ord->order_product_quanity * $ord->product_price;
        //             $subtotal +=$total;
        //             $output.='
        //                     <tr>
        //                         <td>'.$ord->product_name.'</td>
        //                         <td>'.$ord->order_product_quanity.'</td>
        //                         <td>'.number_format($ord->product_price,0,',','.').'đ'.'</td>
        //                         <td>'.number_format($total,0,',','.').'đ'.'</td>
        //                     </tr>';
        //         } 
        //         if($discount){
        //             $output.='
        //                 <tr>
        //                     <td colspan="2">
        //                         <p>Mã giảm giá: '.$discount->discount_code.'</p>                               
        //                         <p>Phí ship:'.number_format(30000,0,',','.').'đ'.'</p>
        //                         <p>Tổng tiền giảm: '.number_format($subtotal* ($discount->discount_percent/100),0,',','.').'đ'.'</p>
        //                         <p>Tổng tiền:'.number_format($subtotal*(1 - $discount->discount_percent/100)+30000,0,',','.').'đ'.'</p>
        //                     </td>
        //                 </tr>
        //                 ';
        //         }else{
        //             $output.='
        //             <tr>
        //                 <td colspan="2">                                                  
        //                     <p>Phí ship:'.number_format(30000,0,',','.').'đ'.'</p>
        //                     <p>Tổng tiền:'.number_format($subtotal+30000,0,',','.').'đ'.'</p>
        //                 </td>
        //             </tr>
        //             ';
        //         } 
                
        //         $output.='</tbody>
        //                 </table>';
        //         $output.='<p>Cảm ơn quý khách đã ủng hộ shop nhé.</p>';
        return $output;
    }

    public function detailOrder($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $detail_order = OrderDetails::where('order_id', $id)->get();
            $order = Order::where('order_id', $id)->get();
            foreach ($order as $key => $ord) {
                $account_id = $ord->account_id;
                $shipping_id = $ord->shipping_id;
            }
            $account = Account::where('account_id', $account_id)->first();
            $shipping = Shipping::where('shipping_id', $shipping_id)->first();

            $order_details = OrderDetails::with('product')->where('order_id', $id)->get();
            return view('order.detail_order')->with(compact('detail_order', 'account', 'shipping', 'order_details'));
        }
    }

    public function deleteOrder($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $detail_order = DB::table('tbl_order_detail')->where('order_id', $id)->get();
            foreach ($detail_order as $key => $ord) {
                $productData = array();
                $product = DB::table('tbl_product')->where('product_id', $ord->product_id)->first();

                $productData['product_quanity'] = $product->product_quanity + $ord->order_product_quanity;

                DB::table('tbl_product')->where('product_id', $ord->product_id)->update($productData);
                DB::table('tbl_order_detail')->where('order_detail_id', $ord->order_detail_id)->delete();
            }
            $delete_order = DB::table('tbl_order')->where('order_id', $id)->delete();
            Session::put('message', 'Xóa đơn hàng thành công');
            return redirect('/show-order-admin');
        }
    }

    public function unStatusOrder($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_order')->where('order_id', $id)->update(['order_status' => 0]);
            Session::put('message', 'Đơn hàng đang xử lý');
            return redirect('/show-order-admin');
        }
    }

    public function statusOrder($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_order')->where('order_id', $id)->update(['order_status' => 1]);
            Session::put('message', 'Đơn hàng đã được xử lý');
            return redirect('/show-order-admin');
        }
    }

    public function historyOrder()
    {
        if (!Session::get('account_id')) {
            return Redirect::to('/login-checkout')->with('error', 'Vui lòng đăng nhập để xem lịch sử mua hàng!');
        } else {

            $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
                ->orderBy('brand_id', 'DESC')->get();
            $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
                ->orderBy('supplier_id', 'DESC')->get();

            $account_id = Session::get('account_id');

            $all_orders = DB::table('tbl_order')->where('account_id', $account_id)->orderBy('order_id', 'DESC')
                ->paginate(4)->appends(request()->query());

            return view('order.history_order')->with('all_orders', $all_orders)
                ->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
        }
    }

    public function showPurchaseOrderDetail(Request $request)
    {
        if (!Session::get('account_id')) {
            return Redirect::to('/login-checkout')->with('error', 'Vui lòng đăng nhập để xem lịch sử mua hàng!');
        } else {
            $data = $request->all();
            $order_details = DB::table('tbl_order_detail')->where('order_id', $data['order_id'])->get();
            $output = '';
            $output = '
        <table class="table_detail_history_order">
            <thead>
                <tr>
                    <th scope="col" style="width: 50px;" align="center">STT</th>
                    <th scope="col" style="width: 400px;" ">Tên sản phẩm</th>
                    <th scope="col" style="width: 200px;" align="center">Giá</th>
                    <th scope="col" style="width: 200px; text-align:center">Số lượng</th>
                    <th scope="col" align="center">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
        ';
            $i = 0;
            foreach ($order_details as $key => $od) {
                $i++;
                $output .= '
                <tr>
                    <td align="center">' . $i . '</td>
                    <td style="width: 200px; ">
                        <a href="' . url('/chi-tiet-san-pham/' . $od->product_id) . '" target = "_blank" style="color:black; width: 340px; display:block; white-space: nowrap;overflow: hidden; text-overflow: ellipsis;">' . $od->product_name . '</a>
                    </td>
                    <td >' . number_format($od->product_price) . ' VNĐ</td>
                    <td align="center">' . $od->order_product_quanity . '</td>
                    <td >' . number_format($od->order_product_quanity * $od->product_price) . ' VNĐ</td>
                </tr>
            ';
            }
            $output .= '
            </tbody>
        </table>
            ';
            return response($output);
        }
    }
}
