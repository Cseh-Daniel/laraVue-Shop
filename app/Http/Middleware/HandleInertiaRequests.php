<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $cartId = auth()->user() ? auth()->user()->id : Session::getId();
        $cart = \Cart::session($cartId);

        return array_merge(parent::share($request), [

            'auth.user' => fn () => $request->user() ?
                ['username' => $request->user()->name]
                : null,
            'cart' => [
                'items'=>$cart->getContent(),
                'total'=>$cart->getTotal()
                ]

        ]);
    }
}
