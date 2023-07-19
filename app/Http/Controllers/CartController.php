<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
// use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * returns active user id or session id for guests
     */
    public function getCartId()
    {
        $userId = auth()->user() ? auth()->user()->id : Session::getId();
        return $userId;
    }

    /**
     * Gives back the product information for the cart of the active user.
     */
    public function getCartContent($userId)
    {
        $cartItems = Cart::select('carts.id', 'user_id', 'product_id', 'name', 'price', 'qty')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->where('user_id', '=', $userId)->get();
        return $cartItems;
    }

    public function getCartTotal()
    {

        $cartTotal = $this->getCartContent($this->getCartId());
        $total = 0;
        foreach ($cartTotal as $i) {
            $total += $i['price'] * $i['qty'];
        }
        return $total;
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

        $userId = $this->getCartId(); //userId or sessionId
        $p = Product::find($req['id']);

        $cartItem = [
            'user_id' => $userId,
            'product_id' => $p['id'],
            'qty' => $req['qty']
        ];

        //ellenőrizni benne van-e már a termék a kosárban
        $items = Cart::getItems($userId, $p['id']);
        if (count($items) > 0) {

            Cart::where('id', $items[0]->id)->update(['qty' => $items[0]->qty + $req['qty']]);
        } else {

            Cart::create($cartItem);
        }
    }

    /**
     * Removes choosen product from cart
     */
    public function removeProd($id)
    {
        Cart::destroy($id);
    }

    /**
     * Changes quantity of choosen product
     */
    public function updateCart(Request $req)
    {
        $req = $req->validate([
            'id' => ['integer', 'required'],
            'qty' => ['integer', 'required', 'min:1']
        ]);

        Cart::where('id', $req['id'])->update(['qty' => $req['qty']]);
    }

    public function dropCart($userId)
    {

        $cart = $this->getCartContent($userId);

        foreach ($cart as $i) {
            Cart::destroy($i['id']);
        }
    }

    public function changeOwner($userId, $sessionId)
    {

        //$this->dropCart($userId);
        $cart = $this->getCartContent($userId);
        foreach ($cart as $i) {
            Cart::where('user_id', (string)$userId)->update(['user_id' => (string)999]);
            //string-re kell alakítani különben hiba, mivel a cartban a user_id string a session_id miatt
        }
    }
}
