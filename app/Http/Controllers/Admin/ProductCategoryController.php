<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainPageTitle = 'Category Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Home Category';

        if($request->ajax())
        {
            $productCategory = ProductCategory::select();
            return datatables()->of($productCategory)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query);
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.product-category.index', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainPageTitle = 'Category Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Create Category';

        return view('admin.product-category.create-edit', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
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
            'name' => 'required'
        ]);

        $productCategory = ProductCategory::create($request->all());

        return redirect()->route('admin.category.index')->with('status', 'Successfully Create Product Category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        $mainPageTitle = 'Category Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Update Category';

        return view('admin.product-category.create-edit', compact('productCategory', 'mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $productCategory->update($request->all());

        return redirect()->route('admin.category.index')->with('status', 'Successfully Update Product Category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        try {
            $productCategory->delete();
            return redirect()->route('admin.category.index')->with('status', 'Successfully Destroy Product Category');
        } catch (\Throwable $th) {
            return redirect()->route('admin.category.index')->with('error', 'Failed Destroy Product Category');
        }
    }

    public function getActionColumn($data)
    {
        $editBtn = route('admin.category.edit', $data->id);
        $deleteBtn = route('admin.category.destroy', $data->id);
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
