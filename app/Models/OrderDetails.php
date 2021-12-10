<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id', 'order_id', 'order_product_quanity','product_name','product_price'
    ];
    protected $primarykey = 'order_detail_id';
    protected $table = 'tbl_order_detail';

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
