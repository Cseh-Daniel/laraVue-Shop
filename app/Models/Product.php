<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'file_path',
    ];

    public $timestamps = false; //updated_at és created_at átugrása Product::create() használatakor

    public static function filterByName($name)
    {
        return Product::where('name', 'like', '%' . $name . '%');
    }

    public static function filterByPrice($min, $max)
    {

        return Product::whereBetween('price', [$min, $max]);
    }
}
