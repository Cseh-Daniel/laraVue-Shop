<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'picPath',
    ];

    public $timestamps = false; //updated_at és created_at átugrása Product::create() használatakor
}
