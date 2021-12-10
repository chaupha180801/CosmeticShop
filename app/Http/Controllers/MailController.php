<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use Carbon\Carbon;
class MailController extends Controller
{

    public function sendCoupon($percent, $quantity, $desc, $code){
        $customer = DB::table('tbl_account')->orderBy('account_id','ASC')->get();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $discount = DB::table('tbl_discount')->where('discount_code',$code)->first();
        $start_discount = $discount->discount_start;
        $end_discount = $discount->discount_end;
        $title_email = "Mã khuyến mãi ngày".' '.$now;
        $data = [];
        foreach($customer as $cst){
            $data['email'][] = $cst->account_email;
        }
        $discount = array(
            'start_discount'=> $start_discount,
            'end_discount'=> $end_discount,
            'percent'=> $percent,
            'quantity'=> $quantity,
            'desc'=> $desc,
            'code'=> $code
        );
        Mail::send('pages.send_discount', ['discount'=>$discount],function($message) use ($title_email,$data){
            $message->to($data['email'])->subject($title_email);
            $message->from($data['email'],$title_email);
        });  
        
        return redirect()->back()->with('message', 'Gửi mã khuyến mãi cho khách hàng thành công');
    }

    public function mail_example(){
        return view('pages.send_discount');
    }
}
