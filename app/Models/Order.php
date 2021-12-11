<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Product;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'shipping_id', 'payment_id', 'account_id','discount_id','order_total','order_status','order_date'
    ];
    protected $primarykey = 'order_id';
    protected $table = 'tbl_order';

    
}
