<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainPageTitle = 'Product Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Home Product';

        if($request->ajax())
        {
            $products = Product::with('product_category')->select();
            return datatables()->of($products)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query);
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.product.index', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainPageTitle = 'Product Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Create Product';

        $category = ProductCategory::get()->pluck('name', 'id');

        return view('admin.product.create-edit', compact('mainPageTitle', 'subPageTitle', 'pageTitle', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'product_category_id' => 'required|exists:product_categories,id',
            'quantity' => 'required'
        ]);

        $product = Product::create($request->all());

        return redirect()->route('admin.product.index')->with('status', 'Success Create Product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $mainPageTitle = 'Product Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Create Or Edit Product';

        $category = ProductCategory::get()->pluck('name', 'id');

        return view('admin.product.create-edit', compact('product', 'mainPageTitle', 'subPageTitle', 'pageTitle', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
            'product_category_id' => 'required|exists:product_categories,id',
            'quantity' => 'required'
        ]);

        $product->update($request->all());

        return redirect()->route('admin.product.index')->with('status', 'Success Update Product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return redirect()->route('admin.product.index')->with('status', 'Success Delete Product');
        } catch (\Throwable $e) {
            return redirect()->route('admin.product.index')->with('status', 'Failed Delete Product');
        }
}

    public function getActionColumn($data)
    {
        $editBtn = route('admin.product.edit', $data->id);
        $deleteBtn = route('admin.product.destroy', $data->id);
        $ident = Str::random(10);
        return
        '<a href="'.$editBtn.'" class="btn mx-1 my-1 btn-sm btn-success">Edit</a>'
        . '<input form="form'.$ident .'" type="submit" value="Delete" class="mx-1 my-1 btn btn-sm btn-danger">
        <form id="form'.$ident .'" action="'.$deleteBtn.'" method="post">
        <input type="hidden" name="_token" value="'.csrf_token().'" />
        <input type="hidden" name="_method" value="DELETE">
        </form>';
    }
}
