<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {

        if ($req->has('name')) {
            //dd($req['name']);
            return inertia(
                'Home',
                [
                    'products' => Product::query()->when(
                        $req['name'],
                        function ($query, $name) {
                            $query->where('name', 'like', '%' . $name . '%');
                        }
                    )
                        ->paginate(4)
                        ->withQueryString()
                ]
            );
        }

        if ($req->has('price')) {
            //dd($req['price']);
            return inertia(
                'Home',
                [
                    'products' => Product::query()->when(
                        $req['price'],
                        function ($query, $price) {
                            $query->where('price', '=', $price);
                        }
                    )
                        ->paginate(4)
                        ->withQueryString()
                ]
            );
        }

        if ($req->has('sort')) {

            if ($req['sort'] == 'priceDesc') {

                // dd($req['sort']);

                return inertia('Home', ['products' => Product::orderBy('price', 'DESC')->Paginate(4)->withQueryString()]);
            } else if ($req['sort'] == 'priceAsc') {

                // dd($req['sort']);

                return inertia('Home', ['products' => Product::orderBy('price', 'ASC')->Paginate(4)->withQueryString()]);
            }
        }

        return inertia('Home', ['products' => Product::Paginate(4)]);
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
            'file_path' => ['required', 'file', 'image', 'max:10240'],
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
    public function destroy(Request $request, string $id)
    {
        $p = Product::find($id);

        if (Product::destroy($id) && $p['file_path']) {
            $file = File::delete($p['file_path']);
        }
        return redirect(url()->previous());
    }


    public function cartIndex()
    {

        return inertia('Cart/Index');

    }
}
