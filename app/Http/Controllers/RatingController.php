<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use Carbon\Carbon;

class RatingController extends Controller
{
    public function saveRating(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::table('tbl_rating')->insert([
                'product_id' => $id,
                'rating_number' => $request->number,
                'rating_content' => $request->content,
                'rating_user_id' => Session::get('account_id'),
                'rating_status' => 0,
                'rating_time' => Carbon::now(),
                'rating_parent_id' => 0,
                'rating_update_time' => Carbon::now()
            ]);
            $product = Product::find($id);
            $product->product_total_rating += $request->number;
            $product->product_total_comment += 1;
            $product->save();
            return response()->json(['code' => '1']);
        }
    }

    //admin
    public function unDisplayRating($id)
    {

        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_rating')->where('rating_id', $id)->update(['rating_status' => 0]);
            Session::put('message', 'Bạn chưa duyệt bình luận thành công');
            return redirect('/show-rating');
        }
    }

    public function displayRating($id)
    {

        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_rating')->where('rating_id', $id)->update(['rating_status' => 1]);
            Session::put('message', 'Bạn đã duyệt bình luận thành công');
            return redirect('/show-rating');
        }
    }

    public function showRating()
    {

        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $all_rating = DB::table('tbl_rating')
                ->join('tbl_product', 'tbl_product.product_id', '=', 'tbl_rating.product_id')
                ->join('tbl_account', 'tbl_account.account_id', '=', 'tbl_rating.rating_user_id')
                ->where('rating_parent_id',0)
                ->orderBy('rating_id', 'DESC')->paginate(6);
            $all_reply = DB::table('tbl_rating')->get();
            return view('rating.show_rating')->with('all_rating', $all_rating)->with('all_reply', $all_reply);
        }
    }

    public function deleteRating($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $delete_rating = DB::table('tbl_rating')->where('rating_id', $id)->delete();
            Session::put('message', 'Xóa đánh giá thành công');
            return redirect('/show-rating');
        }
    }

    public function replyComment(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_rating')->insert([
                'product_id' => $request->rating_product_id,
                'rating_content' => $request->comment,
                'rating_number' => 0,
                'rating_user_id' => 12,
                'rating_status' => 1,
                'rating_time' => Carbon::now(),
                'rating_parent_id' => $request->rating_id,
                'rating_update_time' => Carbon::now()
            ]);
        }
    }
}
