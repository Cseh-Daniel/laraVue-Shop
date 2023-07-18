<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public static function find($uId,$pId)
    {
        $items=[];
        $cart = DB::select("select * from carts where user_id=:uId and product_id=:pId",['uId'=>$uId,'pId'=>$pId]);
        foreach($cart as $item){
            array_push($items,['user_id'=>$item->user_id,'product_id'=>$item->product_id,'qty'=>$item->qty]);
        }
        return $items;
    }

}
