<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\CategoryProductModel;

session_start();

class CategoryProduct extends Controller
{
    public function showCategory()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $all_category = DB::table('tbl_category_product')->paginate(3);
            return view('category.show_category')->with('all_category', $all_category);
        }
    }

    public function addCategory()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            return view('category.add_category');
        }
    }

    public function saveCategory(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $data = array();
            $data['category_name'] = $request->category_product_name;
            $data['category_desc'] = $request->category_product_desc;
            $data['category_status'] = $request->category_product_status;

            DB::table('tbl_category_product')->insert($data);
            Session::put('message', 'Thêm danh mục sản phẩm thành công');
            return redirect('/add-category');
        }
    }

    public function unDisplayCategory($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_category_product')->where('category_id', $id)->update(['category_status' => 0]);
            Session::put('message', 'Bạn đã ẩn danh mục thành công');
            return redirect('/show-category');
        }
    }

    public function displayCategory($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_category_product')->where('category_id', $id)->update(['category_status' => 1]);
            Session::put('message', 'Bạn đã kích hoạt danh mục thành công');
            return redirect('/show-category');
        }
    }

    public function editCategory($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $edit_category = DB::table('tbl_category_product')->where('category_id', $id)->first();
            $magage_category = view('category.edit_category')->with('edit_category', $edit_category);
            return view('admin_layout')->with('category.edit_category', $magage_category);
        }
    }


    public function updateCategory(Request $request, $id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $category = array();
            //$brand['brand_id'] = $id;
            $category['category_name'] = $request->category_product_name;
            $category['category_desc'] = $request->category_product_desc;
            //$brand->save();
            DB::table('tbl_category_product')->where('category_id', $id)->update($category);
            Session::put('message', 'Cập danh mục sản phẩm thành công');
            return redirect('/show-category');
        }
    }

    public function deleteCategory($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $delete_product = DB::table('tbl_product')->where('category_id', $id)->delete();
            $delete_category = DB::table('tbl_category_product')->where('category_id', $id)->delete();
            Session::put('message', 'Xóa danh mục sản phẩm thành công');
            return redirect('/show-category');
        }
    }

    //end admin page
    public function showCategoryHome(Request $request, $id)
    {
     
            $danhmuc = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'DESC')->get();
            $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'DESC')->get();
            $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')->orderBy('supplier_id', 'DESC')->get();
            $bestsellers = DB::table('tbl_product')
            ->join('tbl_order_detail','tbl_order_detail.product_id','=','tbl_product.product_id')            
            ->selectRaw('sum(tbl_order_detail.order_product_quanity) as soluongban')
            ->groupBy('tbl_product.product_id','tbl_product.product_img','tbl_product.product_quanity',
            'tbl_product.product_name','tbl_product.product_price',
            'tbl_product.product_total_comment','tbl_product.product_total_rating')
            ->orderByDesc('soluongban')
            ->addSelect('tbl_product.product_id','tbl_product.product_img','tbl_product.product_quanity',
            'tbl_product.product_name','tbl_product.product_price',
            'tbl_product.product_total_comment','tbl_product.product_total_rating')
            ->take(5)->get();

            if (isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == 'giam_dan') {
                    $danhmuc_sanpham = Product::with('category')->where('category_id', $id)->orderBy('product_price', 'DESC')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'tang_dan') {
                    $danhmuc_sanpham = Product::with('category')->where('category_id', $id)->orderBy('product_price', 'ASC')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'kytu_za') {
                    $danhmuc_sanpham = Product::with('category')->where('category_id', $id)->orderBy('product_name', 'DESC')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'kytu_az') {
                    $danhmuc_sanpham = Product::with('category')->where('category_id', $id)->orderBy('product_name', 'ASC')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'moi_nhat') {
                    $danhmuc_sanpham = Product::with('category')->where('category_id', $id)->orderBy('product_id', 'DESC')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'ban_chay') {
                    $danhmuc_sanpham = Product::with('category')->where('category_id', $id)
                        ->join('tbl_order_detail', 'tbl_order_detail.product_id', '=', 'tbl_product.product_id')
                        ->selectRaw('sum(tbl_order_detail.order_product_quanity) as soluongban')
                        ->groupBy(
                            'tbl_product.product_id',
                            'tbl_product.product_img',
                            'tbl_product.product_quanity',
                            'tbl_product.product_name',
                            'tbl_product.product_price',
                            'tbl_product.product_total_comment',
                            'tbl_product.product_total_rating'
                        )
                        ->orderByDesc('soluongban')
                        ->addSelect(
                            'tbl_product.product_id',
                            'tbl_product.product_img',
                            'tbl_product.product_quanity',
                            'tbl_product.product_name',
                            'tbl_product.product_price',
                            'tbl_product.product_total_comment',
                            'tbl_product.product_total_rating'
                        )
                        ->paginate(9)->appends(request()->query());
                }
            } else {
                $danhmuc_sanpham = DB::table('tbl_product')->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
                    ->where('tbl_product.category_id', $id)->paginate(9);
            }
            $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id', $id)->limit(1)->get();
            return view('pages.category.show_category')->with('category', $danhmuc)->with('brand', $thuonghieu)->with('supplier', $nhacungcap)
                ->with('category_by_id', $danhmuc_sanpham)->with('category_name', $category_name)->with("bestsellers", $bestsellers);
    }

    public function searchCategoryAdmin(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $timkiem = $request->tukhoacategory;
            $danhmuc = DB::table('tbl_category_product')->where('category_name', 'like', '%' . $timkiem . '%')
                ->orderBy('category_id', 'ASC')->get();
            return view('category.search_category')->with('category', $danhmuc);
        }
    }
}
