<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Storage;
use Cart;
use App\Models\Brand;
session_start();

class CartController extends Controller
{
    public function showCart()
    {
        $sanpham = DB::table('tbl_product')->where('product_state', '1')->get();
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('cart.show_cart')->with('brand', $thuonghieu)
        ->with('supplier', $nhacungcap)->with('sanpham', $sanpham);
    }

    public function AddProductCart(Request $request){
        $data['id'] = $request->productid_hidden;
        $data['qty'] = $request->qty_cart;
        $data['name'] = $request->product_cart_name;
        $data['price'] = $request->product_cart_price;
        $data['weight'] = 1;
        $data['options']['image'] = $request->product_cart_image;
        Cart::add($data);



       
        $danhmuc = DB::table('tbl_category_product')
        ->where('category_status', '1')
        ->orderBy('category_id','DESC')->get();
        
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();

        $all_product = DB::table('tbl_product')->where('product_state', '1')
        ->orderBy('product_id','DESC')->paginate(6);

        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();

        Session::put('message','Thêm sản phẩm thành công');
      
        return redirect()->back();
    }

    public function DeleteProductCart($id){
        Cart::update($id, 0);
        $sanpham = DB::table('tbl_product')->where('product_state', '1')->get();
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('cart.show_cart')->with('brand', $thuonghieu)
        ->with('supplier', $nhacungcap)->with('sanpham', $sanpham);
    }

    public function UpdateQuantityCart(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->qty_cart;
        if ($qty >= 0) {
            Cart::update($rowId,$qty);
        }
    }
}
