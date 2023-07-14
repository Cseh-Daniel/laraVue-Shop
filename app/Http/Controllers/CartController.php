<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function addToCart($prodId): void
    {
        $userId = auth()->user() ? auth()->user()->id : Session::getId();
        // dd(\Cart::getTotal());


        $p = Product::find($prodId);
        //dd($p['name'], $p['price'], $userId);

        $cart = \Cart::session($userId);

        $cart->add(array(
            'id' => $p['id'],
            'name' => $p['name'],
            'price' => $p['price'],
            'quantity' => 1
        ));
    }

    public function getCart()
    {
        $userId = auth()->user() ? auth()->user()->id : Session::getId();
        $cart = \Cart::session($userId);

        dd($cart->getContent());
    }
}
