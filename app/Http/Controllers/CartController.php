<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
     * Gives back the product information for the cart
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

        $query = DB::select(
            "
        select sum(qty*price) as total
        from products, carts
        where
        products.id = carts.product_id
        and
        carts.user_id=:id
        ",
            ['id' => $this->getCartId()]
        );

        return $query[0]->total;
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

        $userId = $this->getCartId();

        $items = Cart::getItems($userId, $req['id']);

        if (count($items) > 0) {

            Cart::where('id', $items[0]->id)->update(['qty' => $items[0]->qty + $req['qty']]);
        } else {

            $cartItem = [
                'user_id' => $userId,
                'product_id' => $req['id'],
                'qty' => $req['qty']
            ];

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


    /**
     * Shows the form if user had products in both profile cart and guest user cart
     */
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

    /**
     * Change the cart owner
     */
    public function changeCartOwner($cartId = null)
    {
        if (!$cartId) {
            $req = $_REQUEST;

            $this->dropCart([$req['dropId']]);

            if ($req['dropId'] == auth()->user()->id) {
                $cartId = $req['keepId'];
            }
        }
        Cart::where('user_id', (string)$cartId)->update(['user_id' => (string)auth()->user()->id]);
    }


    /**
     * Compares the guest and profile carts.
     * If both has items returns form.
     * Only guest cart has item they will be assigned for the logged in user
     * If both empty returns false
     */
    public function compareCarts($sessionId)
    {
        $sessionQty = count($this->getCartContent($sessionId));
        $userQty = count($this->getCartContent(auth()->user()->id));

        if ($sessionQty != 0 && $userQty != 0) {

            return $this->changeCartForm(auth()->user()->id, $sessionId);
        } else if ($sessionQty != 0) {

            $this->changeCartOwner($sessionId);
        }

        return false;
    }
}
