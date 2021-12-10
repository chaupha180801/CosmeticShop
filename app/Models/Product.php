<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryProductModel;

class Product extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'product_name', 'category_id', 'brand-id', 'supplier_id', 'discount_id',
        'product_price', 'product_img', 'product_desc', 'product_quanity',
         'product_status', 'product_state', 'product_expire'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';
    
    public function category(){
        return $this->belongsTo('App\Models\CategoryProductModel', 'category_id');

    }
}
