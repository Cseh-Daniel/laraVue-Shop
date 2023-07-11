<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //dd(Product::paginate(3));
        return inertia('Home', ['products' => Product::Paginate(3)]);
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
        $req = $request->validate([
            'name' => ['required', 'string'],
            'file_path' => ['file', 'nullable', 'image', 'max:10240'],
            'price' => ['required', 'integer']
        ]);

        $file = $request->file('file_path');
        $fileName = $req['name'];
        $fileName = str_replace(" ", "_", $fileName);
        $fileName = $fileName . '.' . $file->getClientOriginalExtension();

        //dd($fileName);

        $req['file_path'] = 'uploads/prod/' . $fileName;
        // dd($req['file_path'],$req['name'],$req['price']);

        Product::create($req);
        $file->move('uploads/prod', $fileName);
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

        $product = Product::find($id);

        //dd($product['name']);

        return inertia("Products/Create", [
            "title" => "Edit Product",
            "product" => $product
        ]);

        //return inertia('Products/Create',['test'=>'asdf']);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $req = $request->validate([
            'name' => ['required', 'string'],
            'file_path' => ['file', 'image', 'max:10240'],
            'price' => ['required', 'integer']
        ]);

        $file = $request->file('file_path');
        $fileName = $req['name'];
        $fileName = str_replace(" ", "_", $fileName);
        $fileName = $fileName . '.' . $file->getClientOriginalExtension();

        $req['file_path'] = 'uploads/prod/' . $fileName;
        Product::where('id', $id)->update($req);
        $file->move('uploads/prod', $fileName);

        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $p = Product::find($id);

        if (Product::destroy($id) && $p['file_path']) {
            $file = File::delete($p['file_path']);
        }
    }
}
