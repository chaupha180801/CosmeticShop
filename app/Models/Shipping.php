<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'shipping_name', 'shipping_phone', 'shipping_email',
        'shipping_note','shipping_province','shipping_district','shipping_commune','shipping_address'
    ];
    protected $primarykey = 'shipping_id';
    protected $table = 'tbl_shipping';
}
