<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Home',['products'=>Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $req=$request->validate([
            'name'=>['required','string'],
            'picPath'=>['string','nullable'],
            'price'=>['required','integer']
        ]);

        Product::create($req);

        //return inertia(dd($req));
        return redirect("/");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //return inertia(dd(User::find($id)));
        //return inertia('Products/Create',["product"=>Product::find($id)]);
        return dd(Product::find($id)->through(
            fn($product)=>[
                'name'=>$product->name,
                'price'=>$product->price,
                'picPath'=>$product->picPath
            ]
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
