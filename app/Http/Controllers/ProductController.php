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

        $products = $this->sortAndFilter($req)?$this->sortAndFilter($req)->paginate(4)->withQueryString():Product::Paginate(4);

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
        if ($req->has('name') && $req->has('sort')) {

            $products = $this->filterByNameSorter($req);

            //$order=??sortOrder??($req['sort']);
            //$products=$this->filterByName('xy')->orderBy($order,$sort)
            //$products=$this->filterByName('xy')->orderBy($order,$sort)
        } else if ($req->has('name')) {

            $products = $this->filterByName($req);
        } else if ($req->has('price')) {

            $products = $this->filterByPrice($req);
        } else if ($req->has('sort')) {

            $products = $this->sort($req);
        } else {

            $products = false;
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
    public function destroy(Request $request, string $id)//kell a Request?
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

        return Product::filterByName($req['name']);//->paginate(4)->withQueryString();
    }

    /**
     * filters products by price
     */
    public function filterByPrice($req)
    {
        $min = isset($req['price']['min']) && $req['price']['min'] != null ? $req['price']['min'] : 0;
        $max = isset($req['price']['max']) && $req['price']['max'] != null ? $req['price']['max'] : Product::max('price');

        if ($min > $max) {

            $tmp = $min;
            $min = $max;
            $max = $tmp;
        }

        return Product::filterByPrice($min, $max);//->paginate(4)->withQueryString();
    }

    /**
     * Filters products by name and sorts by price or name
     */
    public function filterByNameSorter($req)
    {
        $sort = str_ends_with($req['sort'], 'Desc') ? "Desc" : "Asc";
        $order = str_starts_with($req['sort'], 'price') ? 'price' : 'name';
/**
 * kód duplikáció sorbarendezéshez
 */
        $products = Product::filterByName($req['name'])->orderBy($order, $sort);//->paginate(4)->withQueryString();

        return $products;
    }

    /**
     * sorts products by price or name
     */
    public function sort($req)
    {
        $sort = str_ends_with($req['sort'], 'Desc') ? "Desc" : "Asc";
        $order = str_starts_with($req['sort'], 'price') ? 'price' : 'name';
        //esetleg ezeket se egy fgv-be?
/**
 * kód duplikáció sorbarendezéshez
 */
        $products = Product::orderBy($order, $sort);//->Paginate(4)->withQueryString();

        return $products;
    }

    public function sorter()
    {
    }

    public function test()
    {
        // dd(Product::filterByName("product")->get());
        // dd(Product::filterByName("product")->orderBy('price','asc')->get());

        //filter by both name and price
        return inertia('test', ['query' => Product::filterByPrice(1, 5000)->where('name','like','%product%')->get()]);

    }
}
