<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use App\Models\Product;
use Storage;
use Cart;
session_start();
class HomeController extends Controller
{
    public function index()
    {
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

        $danhmuc = DB::table('tbl_category_product')
        ->where('category_status', '1')
        ->orderBy('category_id','DESC')->get();

        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
    
        $all_product = DB::table('tbl_product')->where('product_state', '1')
        ->orderBy('product_id','DESC')->paginate(9);

        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();

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

    
        return view('pages.home')->with('category', $danhmuc)
        ->with('brand', $thuonghieu)->with('product', $all_product)
        ->with('supplier', $nhacungcap)->with("bestsellers",  $bestsellers);
    }

    public function autocomplete_ajax(Request $request){
        $data = $request->all();
        if($data['keywords']){
            $product = DB::table('tbl_product')->where('product_state', 1)
            ->where('product_name', 'LIKE', '%'.$data['keywords'].'%')->get();
            $output = '<ul class="dropdown-menu" style="display:block;j">';
            foreach($product as $key => $val){
                $output .= '<li class="li_search_ajax"><a href="#">'
                    .$val->product_name
                    .'</a><li>';
            }
            $output .= '</ul>';
            return $output;
        }
    }

    public function search(Request $request){
        $timkiem = $request->tukhoa;
        $danhmuc = DB::table('tbl_category_product')
        ->where('category_status', '1')
        ->orderBy('category_id','DESC')->get();

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


        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();

        $sort_by = $request->sort_by;
 
        if($sort_by == 'giam_dan'){
            $sort_field = 'product_price';
            $sort_order = 'DESC';
        }elseif($sort_by=='tang_dan'){
            $sort_field = 'product_price';
            $sort_order = 'ASC';               
        }elseif($sort_by=='kytu_za'){
            $sort_field = 'product_name';
            $sort_order = 'DESC';        
        }elseif($sort_by=='kytu_az'){
            $sort_field = 'product_name';
            $sort_order = 'ASC';                       
        }elseif($sort_by == 'moi_nhat'){
            $sort_field = 'product_id';
            $sort_order = 'DESC';
        }else{
            $sort_field = 'product_id';
            $sort_order = 'ASC';
        } 
        if($sort_by == 'ban_chay'){
            $search_product = DB::table('tbl_product')
                ->join('tbl_order_detail','tbl_order_detail.product_id','=','tbl_product.product_id')            
                ->selectRaw('sum(tbl_order_detail.order_product_quanity) as soluongban')
                ->where('tbl_order_detail.product_name', 'like','%'.$timkiem.'%')
                ->groupBy('tbl_product.product_id','tbl_product.product_img','tbl_product.product_quanity',
                'tbl_product.product_name','tbl_product.product_price',
                'tbl_product.product_total_comment','tbl_product.product_total_rating')
                ->orderByDesc('soluongban')
                ->addSelect('tbl_product.product_id','tbl_product.product_img','tbl_product.product_quanity',
                'tbl_product.product_name','tbl_product.product_price',
                'tbl_product.product_total_comment','tbl_product.product_total_rating')
                ->paginate(9)->appends(request()->query());
        }
        else{
            $search_product = DB::table('tbl_product')->where('product_name', 'like','%'.$timkiem.'%')
            ->orderBy($sort_field, $sort_order)->paginate(9)->appends(request()->query());
        }
        $products = DB::table('tbl_product')->where('product_name', 'like','%'.$timkiem.'%')
            ->orderBy($sort_field, $sort_order)->get();
            
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        
        return view('pages.product.search')->with('category', $danhmuc)
        ->with('brand', $thuonghieu)->with('supplier', $nhacungcap)
        ->with('search_product', $search_product)->with('search_keyword', $timkiem)
        ->with('products', $products)->with("bestsellers",  $bestsellers); 
    }  

    public function AddProducSearchCart(Request $request){
        $productId= $request->productid_hidden;
        $quantity = $request->qty_cart;
        $name = $request->product_cart_name;
        $price = $request->product_cart_price;
        $product_imgage = $request->product_cart_image;
        $cart_product = DB::table('tbl_product')->where('product_id', $productId)->first(); 
        $data['id'] = $productId;
        $data['qty'] = $quantity;
        $data['name'] = $name;
        $data['price'] = $price;
        $data['weight'] = 1;
        $data['options']['image'] = $product_imgage;
        Cart::add($data);
        Session::put('message','Thêm sản phẩm thành công');
        return Redirect::to('/tim-kiem');
    }

    public function showService(){
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        return view("relate.show_service")->with('brand', $thuonghieu);
    }

    public function aboutUs(){
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        return view("relate.about_us")->with('brand', $thuonghieu);
    }

}
