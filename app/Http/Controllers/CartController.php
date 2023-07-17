<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function getCart()
    {
        $userId = auth()->user() ? auth()->user()->id : Session::getId();
        $cart = \Cart::session($userId);
        return $cart;
    }

    public function addToCart(Request $req): void
    {
        $minId = Product::orderBy('id', 'asc')->first()->id;
        $maxId = Product::orderBy('id', 'desc')->first()->id;
        $req = $req->validate([
            'id' => ['integer', 'required', 'min:' . $minId, 'max:' . $maxId],
            'qty' => ['integer', 'required', 'min:1']
        ]);

        $cart = $this->getCart();
        $p = Product::find($req['id']);

        $cart->add(array(
            'id' => $p['id'],
            'name' => $p['name'],
            'price' => $p['price'],
            'quantity' => intval($req['qty'])
        ));
    }


    public function getCartContent()
    {
        $cart = $this->getCart();

        dd($cart->getContent());
    }

    public function removeProd($id)
    {
        $cart = $this->getCart();
        $cart->remove($id);
    }

    public function updateCart(Request $req)
    {
        $cart = $this->getCart();

        $req = $req->validate([
            'id' => ['integer', 'required'],
            'qty' => ['integer', 'required', 'min:1']
        ]);
        $cart->update(
            $req['id'],
            array(
                'quantity' =>
                array(
                    'relative' => false,
                    'value' => $req['qty']
                ),
            )
        );
    }
}
