<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\GalleryModel;
use App\Models\Product;
use Cart;
use File;

session_start();

class ProductController extends Controller
{

    public function showProduct(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $sort_by = $request->sort_by;

            if ($sort_by == 'giam_dan') {
                $sort_field = 'product_price';
                $sort_order = 'DESC';
            } elseif ($sort_by == 'tang_dan') {
                $sort_field = 'product_price';
                $sort_order = 'ASC';
            } elseif ($sort_by == 'kytu_za') {
                $sort_field = 'product_name';
                $sort_order = 'DESC';
            } elseif ($sort_by == 'kytu_az') {
                $sort_field = 'product_name';
                $sort_order = 'ASC';
            } else {
                $sort_field = 'product_id';
                $sort_order = 'ASC';
            }

            $all_product = DB::table('tbl_product')
                ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
                ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
                ->join('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_product.supplier_id')
                ->orderby($sort_field, $sort_order)->paginate(5)->appends(request()->query());
            //    $manage_product = view('product_admin.all_product')->with('all_product',$all_product);
            return view('product_admin.show_product_admin')->with(compact('all_product', $all_product));
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addProduct()
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $cate_product = DB::table('tbl_category_product')->orderBy('category_id', 'DESC')->get();
            $brand_product = DB::table('tbl_brand')->orderBy('brand_id', 'DESC')->get();
            $supplier_product = DB::table('tbl_supplier')->orderBy('supplier_id', 'DESC')->get();
            return view('product_admin.add_product_admin')->with(compact('cate_product', 'brand_product', 'supplier_product'));
        }
    }

    public function saveImage($image)
    {
        $path = 'public/backEnd/images';
        $image_name = $image->getClientOriginalName();
        $image_name = current(explode('.', $image_name));
        $new_image_name = $image_name . rand(0, 99) . '.' . $image->getClientOriginalExtension();
        $image->move($path, $new_image_name);
        return $new_image_name;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveProduct(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $data = array();
            $data['product_name'] = $request->product_name;
            $data['product_price'] = $request->product_price;
            $data['product_desc'] = $request->product_desc;
            $data['product_quanity'] = $request->product_quanity;
            $data['product_status'] = 1;
            $data['product_state'] = $request->product_state;
            $data['product_expire'] = $request->product_expire;
            $data['category_id'] = $request->category_id;
            $data['brand_id'] = $request->brand_id;
            $data['supplier_id'] = $request->supplier_id;
            $data['product_total_rating'] = 0;
            $data['product_total_comment'] = 0;
            //Thêm ảnh
            $path_gallery = 'public/backEnd/images/gallery/';
            $path = 'public/backEnd/images/';
            $image = $request->file('product_image');
            $image_name = $image->getClientOriginalName();
            $image_name = current(explode('.', $image_name));
            $new_image_name = $image_name . rand(0, 99) . '.' . $image->getClientOriginalExtension();
            $image->move($path, $new_image_name);
            File::copy($path . $new_image_name, $path_gallery . $new_image_name);
            $data['product_img'] = $new_image_name;

            $pro_id = DB::table('tbl_product')->insertGetId($data);
            $gallery = new GalleryModel();
            $gallery->gallery_img = $new_image_name;
            $gallery->gallery_name = $new_image_name;
            $gallery->product_id = $pro_id;
            $gallery->save();

            Session::put('message', 'Thêm sản phẩm thành công');
            return redirect('/add-product-admin');
        }
    }

    public function unStatusProduct($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_product')->where('product_id', $id)->update(['product_status' => 0]);
            Session::put('message', 'Sản phẩm hết hàng');
            return redirect('/show-product-admin');
        }
    }

    public function statusProduct($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_product')->where('product_id', $id)->update(['product_status' => 1]);
            Session::put('message', 'Sản phẩm còn hàng');
            return redirect('/show-product-admin');
        }
    }

    public function unStateProduct($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_product')->where('product_id', $id)->update(['product_state' => 0]);
            Session::put('message', 'Bạn đã ẩn sản phẩm thành công');
            return redirect('/show-product-admin');
        }
    }

    public function stateProduct($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            DB::table('tbl_product')->where('product_id', $id)->update(['product_state' => 1]);
            Session::put('message', 'Bạn đã hiện sản phẩm thành công');
            return redirect('/show-product-admin');
        }
    }

    public function editProduct($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();
            $supplier_product = DB::table('tbl_supplier')->orderby('supplier_id', 'desc')->get();
            $edit_product = DB::table('tbl_product')->where('product_id', $id)->first();
            $manage_product = view('product_admin.edit_product_admin')->with(compact('edit_product', 'cate_product', 'brand_product', 'supplier_product'));
            return view('admin_layout')->with('product_admin.edit_product_admin', $manage_product);
        }
    }

    public function deleteProduct($id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $product = DB::table('tbl_product')->where('product_id', $id)->first();
            $path = 'public/backEnd/images/' . $product->product_img;
            if (file_exists($path)) {
                unlink($path);
            }
            $delete_product = DB::table('tbl_product')->where('product_id', $id)->delete();
            Session::put('message', 'Xóa sản phẩm thành công');
            return redirect('/show-product-admin');
        }
    }

    public function searchProduct(Request $request)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $search = $request->tukhoa;
            $all_product = DB::table('tbl_product')
                ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
                ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
                ->join('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_product.supplier_id')->where('product_name', 'like', '%' . $search . '%')
                ->paginate(4)->appends(request()->query());

            return view('product_admin.show_product_admin')->with('all_product', $all_product);
        }
    }

    public function index(Request $request)
    {
        $sort_by = $request->sort_by;

        if ($sort_by == 'giam_dan') {
            $sort_field = 'product_price';
            $sort_order = 'DESC';
        } elseif ($sort_by == 'tang_dan') {
            $sort_field = 'product_price';
            $sort_order = 'ASC';
        } elseif ($sort_by == 'kytu_za') {
            $sort_field = 'product_name';
            $sort_order = 'DESC';
        } elseif ($sort_by == 'kytu_az') {
            $sort_field = 'product_name';
            $sort_order = 'ASC';
        } else {
            $sort_field = 'product_id';
            $sort_order = 'ASC';
        }
        $all_product = DB::table('tbl_product')->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->join('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_product.supplier_id')
            ->orderBy($sort_field, $sort_order)->get();
        return view('product_admin.show_product_admin')->with(compact('all_product', $all_product));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateProduct(Request $request, $id)
    {
        if (!Session::get('adminId')) {
            return Redirect::to('/admin')->with('error', 'Vui lòng đăng nhập!');
        } else {
            $product = array();
            $image = $request->file('product_image');
            if ($image != NULL) {
                $new_image_name = $this->saveImage($image);
                $product['product_img'] = $new_image_name;
            }
            $product['product_name'] = $request->product_name;
            $product['product_price'] = $request->product_price;
            $product['product_desc'] = $request->product_desc;
            $product['product_quanity'] = $request->product_quanity;
            $product['product_expire'] = $request->product_expire;
            $product['category_id'] = $request->category_id;
            $product['brand_id'] = $request->brand_id;
            $product['supplier_id'] = $request->supplier_id;
            DB::table('tbl_product')->where('product_id', $id)->update($product);
            Session::put('message', 'Cập nhập sản phẩm thành công');
            return redirect('/show-product-admin');
        }
    }

    public function mapRatingDefault()
    {
        $ratingDefault = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDefault[$i] = array(
                "count_number" => 0,
                "total" => 0,
                "rating_number" => 0
            );
        }
        return $ratingDefault;
    }

    // end pages admin
    public function detailProduct($id)
    {
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')->orderBy('supplier_id', 'DESC')->get();

        $detail_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->join('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_product.supplier_id')
            ->where('tbl_product.product_id', $id)->get();

        foreach ($detail_product as $key => $result) {
            $category_id = $result->category_id;
            $product_id = $result->product_id;
        }
        $account_id = Session::get('account_id');
        $productAccount = DB::table('tbl_order_detail')
        ->join('tbl_order','tbl_order_detail.order_id','=','tbl_order.order_id')
        ->where('tbl_order.account_id',$account_id)->where('tbl_order_detail.product_id',$id)->first();
        
        //gallery
        $gallery = DB::table('tbl_gallery')->where('product_id', $product_id)->get();
        //rating
        $rating = DB::table('tbl_rating')->join('tbl_account', 'tbl_account.account_id', '=', 'tbl_rating.rating_user_id')
            ->where('product_id', $product_id)->orderBy('rating_id', 'DESC')->paginate(10);
        $reply = DB::table('tbl_rating')->where('product_id', $product_id)->orderBy('rating_id', 'DESC')->paginate(10);
        $ratingDashBoard = DB::table('tbl_rating')->groupBy('rating_number')
            ->where('product_id', $product_id)
            ->select(DB::raw('count(rating_number) as count_number'), DB::raw('sum(rating_number) as total'))
            ->addSelect('rating_number')
            ->get()->toArray();

        $ratingDefault = $this->mapRatingDefault();
        foreach ($ratingDashBoard as $item) {
            $ratingDefault[$item->rating_number]['count_number'] = $item->count_number;
            $ratingDefault[$item->rating_number]['total'] = (int)$item->total;
            $ratingDefault[$item->rating_number]['rating_number'] = $item->rating_number;
        }
        $relative_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->join('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_product.supplier_id')
            ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$id])->paginate(4);

        return view('pages.product_detail.show_product_detail')->with('brand', $thuonghieu)->with('supplier', $nhacungcap)
            ->with('product_details', $detail_product)->with('product_relative', $relative_product)->with('gallery', $gallery)
            ->with('rating', $rating)->with('ratingDefault', $ratingDefault)->with('reply', $reply)
            ->with('productAccount',$productAccount);
    }

    public function AddRelativeProductCart(Request $request)
    {
        $productId = $request->productid_hidden;
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
        $thuonghieu = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'DESC')->get();
        $nhacungcap = DB::table('tbl_supplier')->where('supplier_status', '1')->orderBy('supplier_id', 'DESC')->get();

        $detail_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->join('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_product.supplier_id')
            ->where('tbl_product.product_id',  $productId)->get();
        foreach ($detail_product as $key => $result) {
            $category_id = $result->category_id;
            $product_id = $result->product_id;
        }
        //gallery
        $gallery = DB::table('tbl_gallery')->where('product_id', $product_id)->get();
        //đáng giá
        $ratingDashBoard = DB::table('tbl_rating')->groupBy('rating_number')
            ->where('product_id', $product_id)
            ->select(DB::raw('count(rating_number) as count_number'), DB::raw('sum(rating_number) as total'))
            ->addSelect('rating_number')
            ->get()->toArray();

        $ratingDefault = $this->mapRatingDefault();
        foreach ($ratingDashBoard as $item) {
            $ratingDefault[$item->rating_number]['count_number'] = $item->count_number;
            $ratingDefault[$item->rating_number]['total'] = (int)$item->total;
            $ratingDefault[$item->rating_number]['rating_number'] = $item->rating_number;
        }
        $rating = DB::table('tbl_rating')
            ->join('tbl_account', 'tbl_account.account_id', '=', 'tbl_rating.rating_user_id')
            ->where('product_id', $product_id)->orderBy('rating_id', 'DESC')->paginate(10);
        $reply = DB::table('tbl_rating')->where('product_id', $product_id)->orderBy('rating_id', 'DESC')->paginate(10);
        //relative
        $relative_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->join('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_product.supplier_id')
            ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$productId])->paginate(4);

        Session::put('message', 'Thêm sản phẩm thành công');
        return view('pages.product_detail.show_product_detail')->with('brand', $thuonghieu)->with('supplier', $nhacungcap)
            ->with('product_details', $detail_product)->with('product_relative', $relative_product)->with('gallery', $gallery)
            ->with('ratingDefault', $ratingDefault)->with('rating', $rating)->with('reply', $reply);
    }
}
