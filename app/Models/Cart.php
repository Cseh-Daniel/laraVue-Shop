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

    /**
     * gives back the items based on user_id
     * if product_id given only that returns
     */

    public static function getItems($uId,$pId=null)
    {
        if($pId){
            $cart = DB::select("select * from carts where user_id=:uId and product_id=:pId",['uId'=>$uId,'pId'=>$pId]);
        }else{
            $cart = DB::select("select * from carts where user_id=:uId",['uId'=>$uId]);
        }

        $items=[];

        return $cart;
    }

}
