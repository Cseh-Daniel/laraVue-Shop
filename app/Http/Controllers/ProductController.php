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

        if ($req->has('name') && $req->has('sort')) {

            $products = $this->filterByNameSorter($req);
        } else if ($req->has('name')) {

            $products = $this->filterByName($req);
        } else if ($req->has('price')) {

            $products = $this->filterByPrice($req);
        } else if ($req->has('sort')) {

            $products = $this->sort($req);
        } else {

            $products = Product::Paginate(4);
        }

        // $cart = (new CartController)->getCartContent();

        return inertia('Home', ['products' => $products,
        'cart' => [
            'items'=>(new CartController)->getCartContent((new CartController)->getCartId()),
            'total'=>(new CartController)->getCartTotal()
            ]]);
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

        $req['file_path'] = 'uploads/prod/' . $fileName;

        Product::create($req);
        $file->move('uploads/prod', $fileName);
        return redirect("/");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);

        return inertia("Products/Create", [
            "title" => "Edit Product",
            "product" => $product
        ]);
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

        return Inertia::location('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $p = Product::find($id);

        if (Product::destroy($id) && $p['file_path']) {
            File::delete($p['file_path']);
        }
        return redirect(url()->previous());
    }

    /**
     * Filters products by name
     */
    public function filterByName($req)
    {
        $products = Product::query()->when(
            $req['name'],
            function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%');
            }
        )
            ->paginate(4)
            ->withQueryString();

        return $products;
    }

    /**
     * filters products by price
     */
    public function filterByPrice($req)
    {

        // dd($req['price']['min'],$req['price']['max']);

        if ($req['price']['min'] > $req['price']['max']) {
            $tmp['min'] = $req['price']['max'];
            $tmp['max'] = $req['price']['min'];
        } else {
            $tmp['min'] = $req['price']['min'];
            $tmp['max'] = $req['price']['max'];
        }

        $products = Product::query()->when(
            $tmp,
            function ($query, $price) {
                // dd($price);
                $query->whereBetween('price', [$price['min'], $price['max']]);
            }
        )
            ->paginate(4)
            ->withQueryString();
        return $products;
    }

    /**
     * Filters products by name and sorts by price or name
     */
    public function filterByNameSorter($req)
    {
        $sort = str_ends_with($req['sort'], 'Desc') ? "Desc" : "Asc";
        $order = str_starts_with($req['sort'], 'price') ? 'price' : 'name';

        $products = Product::query()->when(
            $req['name'],
            function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%');
            }
        )->orderBy($order, $sort)
            ->paginate(4)
            ->withQueryString();

        return $products;
    }

    /**
     * sorts products by price or name
     */
    public function sort($req)
    {
        $sort = str_ends_with($req['sort'], 'Desc') ? "Desc" : "Asc";
        $order = str_starts_with($req['sort'], 'price') ? 'price' : 'name';

        $products = Product::orderBy($order, $sort)->Paginate(4)->withQueryString();

        return $products;
    }
}
