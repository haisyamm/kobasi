<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function autocomplete(Request $request)
    {
        $data = Product::select("name as value", "id")
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }

    public function show(Product $product)
    { 
        return response()->json($product);
    }

    public function index()
    {   
        $title = "Data Product";
        $products = Product::orderBy('id','asc')->paginate(5);
        return view('positions.index', compact(['positions' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Product";
        return view('positions.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_trx' => 'required'
        ]);

        var_dump($request);
        die;
        
        Product::create($request->post());

        return redirect()->route('positions.index')->with('success','Position has been created successfully.');
    }

    public function edit(Product $product)
    {
        $title = "Edit Data Product";
        return view('positions.edit',compact('position' , 'title'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'keterangan' => 'required',
            'alias' => 'required',
        ]);
        
        $product->fill($request->post())->save();

        return redirect()->route('positions.index')->with('success','Position Has Been updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('positions.index')->with('success','Position has been deleted successfully');
    }
    
}
