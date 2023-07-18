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

    public function getCartContent(){

        //what if we want the cart of the guest user
        $cart = DB::select("select * from carts where user_id=:id",['id'=>$this->getCartId()]);
        //find(userId,productId=null)????
        $cartItems=[];
        foreach($cart as $item){
            $p=Product::find($item->product_id);
            array_push($cartItems,['name'=>$p['name'],'price'=>$p['price'],'quantity'=>$item->qty]);
        }

        return $cartItems;
    }

    /**
     * Appends cart with choosen product
     */
    public function addToCart(Request $req): void
    {
        $this->getCartContent();
        $req = $req->validate([
            'id' => ['integer', 'required'],
            'qty' => ['integer', 'required', 'min:1']
        ]);

        $cartId = $this->getCartId(); //userId or sessionId
        $p = Product::find($req['id']);

        $cartItem=[
            'user_id'=>$cartId,
            'product_id'=>$p['id'],
            'qty'=>$req['qty']
        ];

        //ellenőrizni benne van-e már a termék a kosárban
        $items=count(Cart::find($cartId,$p['id']));

        // dd(count($items));

        $items>0?'':Cart::create($cartItem);

        //Cart::create($cartItem);

        // $cart->add(array(
        //     'id' => $p['id'],
        //     'name' => $p['name'],
        //     'price' => $p['price'],
        //     'quantity' => intval($req['qty'])
        // ));
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
