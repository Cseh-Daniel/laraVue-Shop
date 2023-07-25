<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {

        $products = $this->sortAndFilter($req) ? $this->sortAndFilter($req)->paginate(4)->withQueryString() : Product::Paginate(4);

        return inertia('Home', [
            'products' => $products,
            'cart' => [
                'items' => (new CartController)->getCartContent((new CartController)->getCartId()),
                'total' => (new CartController)->getCartTotal()
            ]
        ]);
    }

    /**
     * Returns sorted or filtered list of products
     */
    public function sortAndFilter($req)
    {
        $sortOrder = $req['sort'] != null ? $this->sortOrder($req) : null;

        $boolPrice = $req['priceMin'] != null || $req['priceMax'] != null;

        if ($boolPrice && $req['name'] != null && $req['sort'] != null) {

            $products = $this->filterByPrice($req)->where('name', 'like', '%' . $req['name'] . '%')->orderBy($sortOrder[0], $sortOrder[1]);
        } else if ($boolPrice && $req['name'] != null) {

            $products = $this->filterByPrice($req)->where('name', 'like', '%' . $req['name'] . '%');
        } else if ($boolPrice && $sortOrder) {

            $products = $this->filterByPrice($req)->orderBy($sortOrder[0], $sortOrder[1]);
        } else if ($req['name'] && $sortOrder) {

            $products = Product::filterByName($req['name'])->orderBy($sortOrder[0], $sortOrder[1]);
        } else if ($req['name']) {

            $products = Product::filterByName($req['name']);
        } else if ($boolPrice) {

            $products = $this->filterByPrice($req);
        } else if ($req['sort']) {

            $products = Product::orderBy($sortOrder[0], $sortOrder[1]);
        } else {

            $products = null;
        }
        return $products;
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $p = Product::find($id);

        if (Product::destroy($id) && $p['file_path']) {
            File::delete($p['file_path']);
        }
        return redirect(url()->previous());
    }

    /**
     * filters products by price
     */
    public function filterByPrice($req)
    {
        $min = isset($req['priceMin']) && $req['priceMin'] != null ? $req['priceMin'] : 0;
        $max = isset($req['priceMax']) && $req['priceMax'] != null ? $req['priceMax'] : Product::max('price');

        if ($min > $max) {

            $tmp = $min;
            $min = $max;
            $max = $tmp;
        }
        return Product::filterByPrice($min, $max);
    }

    /**
     * returns an array
     * first element: order by price/name,
     * second element: sorting asc/desc
     */
    public function sortOrder($req)
    {
        $sort = str_ends_with($req['sort'], 'Desc') ? "Desc" : "Asc";
        $order = str_starts_with($req['sort'], 'price') ? 'price' : 'name';
        return array($order, $sort);
    }
}
