<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
    ];

    public $timestamps = false;
}
