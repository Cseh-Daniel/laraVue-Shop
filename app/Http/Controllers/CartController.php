<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use DeepCopy\Filter\KeepFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

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

    /**
     * returns the total value for the active user
     */
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

    /**
     * Clears out the car for given IDs
     * expects array as input
     */
    public function dropCart($userId = null)
    {
        $userId = !$userId ? $_REQUEST : $userId;
        foreach ($userId as $i) {
            Cart::where('user_id', $i)->delete();
        }
    }

    public function changeCartForm($userId, $sessionId)
    {
        return inertia('Cart/CartChangeForm', [
            'cart' => [
                'old' => [
                    'items' => $this->getCartContent($userId),
                    'id' => $userId
                ],
                'new' => [
                    'items' => $this->getCartContent($sessionId),
                    'id' => $sessionId
                ]
            ]
        ]);
    }

    public function changeCartOwner($cartId = null)
    {
        if (!$cartId) {
            $req = $_REQUEST;

            $this->dropCart([$req['dropId']]);

            if ($req['dropId'] == auth()->user()->id) {
                // Cart::where('user_id', (string)$req['keepId'])->update(['user_id' => (string)auth()->user()->id]);
                $cartId = $req['keepId'];
            }
        }
        //else {
        Cart::where('user_id', (string)$cartId)->update(['user_id' => (string)auth()->user()->id]);
        //}
    }

    public function compareCarts($userId, $sessionId)
    {
        $sessionQty = count($this->getCartContent($sessionId));
        $userQty = count($this->getCartContent(auth()->user()->id));

        if ($sessionQty != 0 && $userQty != 0) {
            // dd('van mind2 kosárban');

            return $this->changeCartForm(auth()->user()->id, $sessionId);
        } else if ($sessionQty != 0) {
            // dd('csak a session kosárban');

            $this->changeCartOwner($sessionId);
        }

        // dd('return false');

        return false;
    }

    /**
     * csak teszt
     */
    public function test()
    {
        return "<h1>Hello</h1>";
    }
}
