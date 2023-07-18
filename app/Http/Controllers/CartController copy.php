<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * returns the cart of the active user
     */
    //##########################
    // public function getCart()
    // {
    //     $userId = auth()->user() ? auth()->user()->id : Session::getId();
    //     $cart = \Cart::session($userId);
    //     return $cart;
    // }

    public function getCart()
    {
        $userId = auth()->user() ? auth()->user()->id : Session::getId();
        return $userId;
    }

    /**
     * Appends cart with choosen product
     */
    public function addToCart(Request $req): void
    {
        $req = $req->validate([
            'id' => ['integer', 'required'],
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

    /**
     * Removes choosen product from cart
     */
    public function removeProd($id)
    {
        $cart = $this->getCart();
        $cart->remove($id);
    }

    /**
     * Changes quantity of choosen product
     */
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
