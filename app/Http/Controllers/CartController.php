<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Storage;
use Cart;
session_start();

class CartController extends Controller
{
    public function showCart()
    {
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('cart.show_cart')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function AddProductCart(Request $request){
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
        return view('pages.home')->with('category', $danhmuc)
        ->with('brand', $thuonghieu)->with('product', $all_product)
        ->with('supplier', $nhacungcap);
    }

    public function DeleteProductCart($id){
        Cart::update($id, 0);
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('cart.show_cart')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function UpdateQuantityCart(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->qty_cart;
        Cart::update($rowId,$qty);
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('cart.show_cart')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function incrementQuantityCart($id){
        $product = Cart::get($id);
        $qty = $product->qty + 1;
        Cart::update($id,$qty);
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('cart.show_cart')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }

    public function decrementQuantityCart($id){
        $product = Cart::get($id);
        $qty = $product->qty - 1;
        Cart::update($id,$qty);
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')
        ->orderBy('brand_id','DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')
        ->orderBy('supplier_id','DESC')->get();
        return view('cart.show_cart')->with('brand', $thuonghieu)->with('supplier', $nhacungcap);
    }
}
