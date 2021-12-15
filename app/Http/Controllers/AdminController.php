<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\ChartClass\Date;
use Illuminate\Support\Facades\Redirect;

session_start();

class AdminController extends Controller
{
    public function index()
    {
       return view('admin_login'); 
    }

    public function show_dasdboard()
    {
        $listDay = Date::getListDayInMonth();
        $listMonth = ['1', '2','3','4','5','6','7','8','9','10','11','12']; 
        $revenueMonth = DB::table('tbl_order')->where('order_status', 0)
        ->whereMonth('order_date', date('m'))
        ->select(\DB::raw('sum(order_total) as total'), \DB::raw('DATE(order_date) day'))
        ->groupBy('day')->get();
        $revenueMonthEstimated = DB::table('tbl_order')->where('order_status', 1)
        ->whereMonth('order_date', date('m'))
        ->select(\DB::raw('sum(order_total) as total'), \DB::raw('DATE(order_date) day'))
        ->groupBy('day')->get();
        $revenueMonthYear = DB::table('tbl_order')->where('order_status', 0)
        ->whereYear('order_date', date('Y'))
        ->select(\DB::raw('sum(order_total) as total'), \DB::raw('MONTH(order_date) month'))
        ->groupBy('month')->get();
        $totalOrder = DB::table('tbl_order')
        ->whereYear('order_date', date('Y'))
        ->select(\DB::raw('count(order_id) as total'), \DB::raw('MONTH(order_date) month'))
        ->groupBy('month')->get();

        $arrayRevenue = [];
        $arrayRevenueEstimated = [];
        $arrayRevenueYear = [];
        $arrayTotalYear = [];
        foreach($listDay as $day){
            $total = 0;
            foreach($revenueMonth as $key =>$revenue){
               if($revenue->day == $day){
                    $total = $revenue->total;
                    break;
               }
            }
            $arrayRevenue[] = $total;
        } 
        
        foreach($listDay as $day){
            $totalEstimated = 0;
            foreach($revenueMonthEstimated as $key =>$revenueEstimated){
               if($revenueEstimated->day == $day){
                    $totalEstimated = $revenueEstimated->total;
                    break;
               }
            }
            $arrayRevenueEstimated[] = $totalEstimated;
        }  

        foreach($listMonth as $month){
            $total = 0;
            foreach($revenueMonthYear as $key =>$revenue){
               if($revenue->month == $month){
                    $total = $revenue->total;
                    break;
               }
            }
            $arrayRevenueYear[] = $total;
        }  

        foreach($listMonth as $month){
            $total = 0;
            foreach($totalOrder as $key =>$order){
               if($order->month == $month){
                    $total = $order->total;
                    break;
               }
            }
            $arrayTotalYear[] = $total;
        }  

        $viewData = ['listDay'     => json_encode($listDay),
                     'arrayRevenue' =>json_encode($arrayRevenue),
                     'arrayRevenueEstimated' =>json_encode($arrayRevenueEstimated),
                     'listMonth' =>json_encode($listMonth),
                     'arrayRevenueYear' =>json_encode($arrayRevenueYear),
                     'arrayTotalYear' =>json_encode($arrayTotalYear)];
        return view('admin.dashboard',$viewData);   
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
            return redirect('/dashboard');

        }
        else {
            Session::put('ErrorMessage', 'Tên đăng nhập hoặc mật khẩu chưa chính xác');
            return redirect('/admin');
        }
    }

    public function logout()
    {
        Session::put('adminUserName','');
        Session::put('adminId', '');
        return redirect('/admin');
    }

   
}
