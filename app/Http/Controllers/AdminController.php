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
       
       
        
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {

            $date = getdate();
        
            $search_product = DB::table('tbl_product')
                    ->join('tbl_order_detail','tbl_order_detail.product_id','=','tbl_product.product_id')            
                    ->selectRaw('sum(tbl_order_detail.order_product_quanity) as soluongban')
                    ->groupBy('tbl_product.product_id','tbl_product.product_img','tbl_product.product_quanity',
                    'tbl_product.product_name','tbl_product.product_price',
                    'tbl_product.product_total_comment','tbl_product.product_total_rating')
                    ->orderByDesc('soluongban')
                    ->addSelect('tbl_product.product_id','tbl_product.product_img','tbl_product.product_quanity',
                    'tbl_product.product_name','tbl_product.product_price',
                    'tbl_product.product_total_comment','tbl_product.product_total_rating')
                    ->get(5);
            $dtt = DB::table('tbl_order')->whereMonth('order_date', '=' , $date['mon'])->sum('order_total');
            $dtn = DB::table('tbl_order')->whereYear('order_date', '=' , $date['year'])->sum('order_total');
            $total_order = DB::table('tbl_order')->count('order_id');
            $dhxn = DB::table('tbl_order')->where('order_status' , '0')->count('order_id');
            $dhdg = $total_order - $dhxn;
            $listDay = Date::getListDayInMonth();
            $listMonth = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
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
            foreach ($listDay as $day) {
                $total = 0;
                foreach ($revenueMonth as $key => $revenue) {
                    if ($revenue->day == $day) {
                        $total = $revenue->total;
                        break;
                    }
                }
                $arrayRevenue[] = $total;
            }

            foreach ($listDay as $day) {
                $totalEstimated = 0;
                foreach ($revenueMonthEstimated as $key => $revenueEstimated) {
                    if ($revenueEstimated->day == $day) {
                        $totalEstimated = $revenueEstimated->total;
                        break;
                    }
                }
                $arrayRevenueEstimated[] = $totalEstimated;
            }

            foreach ($listMonth as $month) {
                $total = 0;
                foreach ($revenueMonthYear as $key => $revenue) {
                    if ($revenue->month == $month) {
                        $total = $revenue->total;
                        break;
                    }
                }
                $arrayRevenueYear[] = $total;
            }

            foreach ($listMonth as $month) {
                $total = 0;
                foreach ($totalOrder as $key => $order) {
                    if ($order->month == $month) {
                        $total = $order->total;
                        break;
                    }
                }
                $arrayTotalYear[] = $total;
            }

            $viewData = [
                'listDay'     => json_encode($listDay),
                'arrayRevenue' => json_encode($arrayRevenue),
                'arrayRevenueEstimated' => json_encode($arrayRevenueEstimated),
                'listMonth' => json_encode($listMonth),
                'arrayRevenueYear' => json_encode($arrayRevenueYear),
                'arrayTotalYear' => json_encode($arrayTotalYear),
                'dtt' => $dtt,
                'dtn' => $dtn,
                'search_product' => $search_product,
                'dhxn' => $dhxn,
                'dhdg' => $dhdg

            ];
            return view('admin.dashboard', $viewData);
        }
    }


    public function check_login(Request $request)
    {
        $email = $request->txtUserName;
        $pass = md5($request->txtPass);

        $result = DB::table('tbl_admin')->where('admin_email', $email)->where('admin_pass', $pass)->first();

        if ($result != null) {
            Session::put('adminUserName', $result->admin_username);
            Session::put('adminId', $result->admin_id);
            Session::put('adminImg', $result->admin_avatar);

            return redirect('/dashboard');
        } else {
            Session::put('ErrorMessage', 'Tên đăng nhập hoặc mật khẩu chưa chính xác');
            return redirect('/admin');
        }
    }

    public function showProfile($id)
    {
        $profile = DB::table('tbl_admin')->where('admin_id', $id)->get();
        return view('profile.show_profileAdmin')->with('profile', $profile);
    }

    public function logout()
    {
        Session::put('adminUserName', '');
        Session::put('adminId', '');
        Session::put('adminImg', '');

        return redirect('/admin');
    }

    public function saveAdmin(Request $request)
    {
        $data = array();
        $data['admin_name'] = $request->adminName;
        $data['admin_username'] = $request->adminName;
        $data['admin_email'] = $request->adminEmail;
        $data['admin_pass'] = md5($request->adminPass);

        $admin_id = DB::table('tbl_admin')->insertGetId($data);
        Session::put('adminId', $admin_id);
        Session::put('adminUserName', $request->adminName);
        return redirect('/dashboard');
    }
    public function editImageProfile(Request $request, $id)
    {
        $image = $request->file('avatar');
        if ($image != NULL) {
            $path = 'public/backEnd/images';
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $image_name);
            DB::table('tbl_admin')->where('admin_id', $id)->update(['admin_avatar' => $image_name]);
            Session::put('adminImg', $image_name);

            return redirect('/profile-admin/' . $id);
        }
    }

    public function updateAdminProfile(Request $request, $id)
    {
        $profile = array();
        $profile['admin_name'] = $request->update_admin_name;
        $profile['admin_username'] = $request->update_admin_username;
        $profile['admin_birth'] = $request->update_admin_birth;
        $profile['admin_phone'] = $request->update_admin_phone;
        $profile['admin_email'] = $request->update_admin_email;
        $profile['admin_address'] = $request->update_admin_address;
        $profile['admin_job'] = $request->update_admin_job;

        DB::table('tbl_admin')->where('admin_id', $id)->update($profile);
        Session::put('message', 'Cập nhật thông tin cá nhân thành công');
        return redirect('/profile-admin/' . $id);
    }

    public function updateAccountProfile(Request $request, $id)
    {
        $profile = array();
        $profile['account_name'] = $request->update_account_name;
        $profile['account_birth'] = $request->update_account_birth;
        $profile['account_phone'] = $request->update_account_phone;
        $profile['account_email'] = $request->update_account_email;
        $profile['account_address'] = $request->update_account_address;
        $profile['account_job'] = $request->update_account_job;

        DB::table('tbl_account')->where('account_id', $id)->update($profile);
        Session::put('message', 'Cập nhật thông tin cá nhân thành công');
        return redirect('/profile/' . $id);
    }
}
