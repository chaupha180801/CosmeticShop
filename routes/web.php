<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\MailController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great
|
*/

Route::get('/',[HomeController::class,'index']);
Route::get('/admin',[AdminController::class,'index']);
Route::get('/dashboard',[AdminController::class,'show_dasdboard']);
Route::get('/logout',[AdminController::class,'logout']);
Route::get('/profile-admin/{id}',[AdminController::class,'showProfile']);
Route::post('/update-image-admin/{id}',[AdminController::class,'editImageProfile']);
Route::post('/update-admin-profile/{id}',[AdminController::class,'updateAdminProfile']);
Route::post('/update-account-profile/{id}',[AdminController::class,'updateAccountProfile']);



Route::get('/print-order/{id}',[OrderController::class,'printOrder']);
//Danh mục sản phẩm ở trang chủ
Route::get('/chi-tiet-danh-muc/{id}',[CategoryProduct::class,'showCategoryHome']);
//tìm kiếm
Route::get('/tim-kiem',[HomeController::class,'search']);
Route::post('/add-product-search-to-cart',[HomeController::class,'AddProducSearchCart']);
Route::get('/dich-vu',[HomeController::class,'showService']);
Route::get('/gioi-thieu',[HomeController::class,'aboutUs']);


Route::post('/timkiem-ajax',[HomeController::class,'autocomplete_ajax']);

Route::post('/admin-dashboard',[AdminController::class,'check_login']);
Route::post('/save-admin',[AdminController::class,'saveAdmin']);

//category
Route::get('/show-category',[CategoryProduct::class,'showCategory']);
Route::get('/add-category',[CategoryProduct::class,'addCategory']);
Route::post('/save-category-product',[CategoryProduct::class,'saveCategory']);
Route::get('/undisplay-category-product/{id}',[CategoryProduct::class,'unDisplayCategory']);
Route::get('/display-category-product/{id}',[CategoryProduct::class,'displayCategory']);
Route::get('/edit-category-product/{id}',[CategoryProduct::class,'editCategory']);
Route::get('/delete-category-product/{id}',[CategoryProduct::class,'deleteCategory']);
Route::post('/update-category/{id}',[CategoryProduct::class,'updateCategory']);
Route::get('/search-category-admin',[CategoryProduct::class,'searchCategoryAdmin']);
Route::post('/loc-san-pham',[CategoryProduct::class,'locSanPham']);

//brand
Route::get('/show-brand',[BrandController::class,'showBrand']);
Route::get('/add-brand',[BrandController::class,'addBrand']);
Route::post('/save-brand',[BrandController::class,'saveBrand']);
Route::get('/undisplay-brand/{id}',[BrandController::class,'unDisplayBrand']);
Route::get('/display-brand/{id}',[BrandController::class,'displayBrand']);
Route::get('/edit-brand/{id}',[BrandController::class,'editBrand']);
Route::get('/delete-brand/{id}',[BrandController::class,'deleteBrand']);
Route::post('/update-brand/{id}',[BrandController::class,'updateBrand']);
Route::get('/search-brand-admin',[BrandController::class,'searchBrandAdmin']);
Route::get('/brand-detail/{id}',[BrandController::class,'DetailBrand']);

//Route::get('/update-brand/{id}', 'BrandController@updateBrand');

//đánh giá
Route::post('/danh-gia/{id}', [RatingController::class,'saveRating']);
Route::get('/show-rating',[RatingController::class,'showRating']);
Route::get('/delete-rating/{id}',[RatingController::class,'deleteRating']);
Route::post('/reply-comment', [RatingController::class,'replyComment']);
//Trả lời bình luận
Route::post('/tra-loi/{id}', [ReplyController::class,'saveReply']);
Route::get('/undisplay-rating/{id}',[RatingController::class,'unDisplayRating']);
Route::get('/display-rating/{id}',[RatingController::class,'displayRating']);
//supplier
Route::get('/show-supplier',[SupplierController::class,'showSupplier']);
Route::get('/add-supplier',[SupplierController::class,'addSupplier']);
Route::post('/save-supplier',[SupplierController::class,'saveSupplier']);
Route::get('/undisplay-supplier/{id}',[SupplierController::class,'unDisplaySupplier']);
Route::get('/display-supplier/{id}',[SupplierController::class,'displaySupplier']);
Route::get('/edit-supplier/{id}',[SupplierController::class,'editSupplier']);
Route::get('/delete-supplier/{id}',[SupplierController::class,'deleteSupplier']);
Route::post('/update-supplier/{id}',[SupplierController::class,'updateSupplier']);

//product-admin

Route::get('/show-product-admin',[ProductController::class,'showProduct']);
Route::get('/add-product-admin',[ProductController::class,'addProduct']);
Route::post('/save-product',[ProductController::class,'saveProduct']);
Route::get('/edit-product/{id}',[ProductController::class,'editProduct']);
Route::get('/delete-product/{id}',[ProductController::class,'deleteProduct']);
Route::get('/search-product',[ProductController::class,'searchProduct']);
Route::get('/unstatus-product/{id}',[ProductController::class,'unStatusProduct']);
Route::get('/status-product/{id}',[ProductController::class,'statusProduct']);
Route::get('/unstate-product/{id}',[ProductController::class,'unStateProduct']);
Route::get('/state-product/{id}',[ProductController::class,'stateProduct']);
Route::get('/chi-tiet-san-pham/{id}',[ProductController::class,'detailProduct']);
Route::post('/add-relative-to-cart',[ProductController::class,'AddRelativeProductCart']);


//customer-admin
Route::get('/show-customer-admin',[CustomerController::class,'showCustomer']);
Route::get('/add-customer',[CustomerController::class,'addCustomer']);
Route::post('/save-customer',[CustomerController::class,'saveCustomer']);
Route::get('/edit-customer/{id}',[CustomerController::class,'editCustomer']);
Route::get('/delete-customer/{id}',[CustomerController::class,'deleteCustomer']);
Route::post('/update-customer/{id}',[CustomerController::class,'updateCustomer']);
Route::get('/search-customer',[CustomerController::class,'searchCustomerAdmin']);


//order-orderdetail
Route::get('/show-order-admin',[OrderController::class,'showOrder']);
// Route::get('/add-customer',[CustomerController::class,'addCustomer']);
// Route::post('/save-order',[OrderController::class,'saveOrder']);
Route::get('/detail-order/{id}',[OrderController::class,'detailOrder']);
Route::get('/delete-order/{id}',[OrderController::class,'deleteOrder']);
Route::get('/unstatus-order/{id}',[OrderController::class,'unStatusOrder']);
Route::get('/status-order/{id}',[OrderController::class,'statusOrder']);
// Route::post('/update-order/{id}',[OrderController::class,'updateOrder']);
// Route::get('/search-customer',[CustomerController::class,'searchCustomerAdmin']);

Route::post('/update-product/{id}',[ProductController::class,'updateProduct']);

//cart
Route::get('/cart',[CartController::class,'showCart']);
Route::post('/add-to-cart',[CartController::class,'AddProductCart']);
Route::get('/delete-to-cart/{id}',[CartController::class,'DeleteProductCart']);
Route::post('/update-cart-quantity',[CartController::class,'UpdateQuantityCart']);

//gallery
Route::get('/add-gallery/{id}',[GalleryController::class,'add_gallery']);
Route::post('/select-gallery',[GalleryController::class,'select_gallery']);
Route::post('/insert-gallery/{id}',[GalleryController::class,'insert_gallery']);
Route::post('/update-gallery-name',[GalleryController::class,'update_gallery_name']);
Route::post('/delete-gallery',[GalleryController::class,'delete_gallery']);
Route::post('/update-gallery',[GalleryController::class,'update_gallery']);
//Login
Route::get('/login-checkout',[CheckoutController::class,'loginCheckout']);
Route::get('/logout-checkout',[CheckoutController::class,'logoutCheckout']);
Route::get('/register-form',[CheckoutController::class,'registerCheckout']);
Route::get('/login-checkout-home',[CheckoutController::class,'loginCheckoutHome']);
Route::get('/register-form-hơm',[CheckoutController::class,'registerCheckout']);
Route::post('/add-customer-account',[CheckoutController::class,'addCustomerAccount']);
Route::post('/login-account',[CheckoutController::class,'loginAccount']);
Route::post('/save-shipping/{id}',[CheckoutController::class,'saveShipping']);
Route::get('/profile/{id}',[CheckoutController::class,'showProfile']);
Route::post('/update_profile/{id}',[CheckoutController::class,'updateProfile']);
Route::get('/checkout/{id}',[CheckoutController::class,'checkOut']);
Route::post('/save-checkout-customer',[CheckoutController::class,'saveCheckoutCustomer']);
Route::post('/address',[CheckoutController::class,'selectAddress']);
Route::get('/delete-shipping/{id}',[CheckoutController::class,'deleteShipping']);


Route::post('/show-purchase-order-details',[OrderController::class,'showPurchaseOrderDetail']);
//order
Route::get('/history-order',[OrderController::class,'historyOrder']);
//discount
Route::get('/show-discount',[DiscountController::class,'showDiscount']);
Route::get('/add-discount',[DiscountController::class,'create']);
Route::get('/save-discount',[DiscountController::class,'saveDiscount']);
Route::get('/delete-discount/{id}',[DiscountController::class,'deleteDiscount']);
Route::get('/edit-discount/{id}',[DiscountController::class,'editDiscount']);
Route::post('/update-discount/{id}',[DiscountController::class,'updateDiscount']);
Route::get('/discount/{code}',[DiscountController::class,'getDiscountInfo']);
//email
Route::get('/coupon/{percent}/{quantity}/{desc}/{code}',[MailController::class,'sendCoupon']);
