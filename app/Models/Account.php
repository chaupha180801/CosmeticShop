<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'account_name', 'account_email', 'account_password', 'account_phone'
    ];
    protected $primarykey = 'account_id';
    protected $table = 'tbl_account';
}