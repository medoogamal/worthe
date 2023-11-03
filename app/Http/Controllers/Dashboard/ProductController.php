<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->middleware(['permission:products-read'])->only('index');
        $this->middleware(['permission:products-create'])->only('create');
        $this->middleware(['permission:products-update'])->only('edit');
        $this->middleware(['permission:products-delete'])->only('destroy');
    }//end of _construct
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::where(function($q) use($request) {
            $q->when($request->search, function($query) use ($request){
                 return $query->where('name','like','%' . $request->search . '%');
             });
            $q->when($request->category_id, function($query) use ($request){
                 return $query->where('category_id','like','%' . $request->category_id . '%');
             });
             return $q;
         })->latest()
         ->paginate(10);
        return view("dashboard.products.index", compact("categories","products"));
    }//end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("dashboard.products.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=> "required",
            "description"=> "required",
            "category_id" =>"required",
            "purchase_price" =>"required",
            "sale_price" =>"required",
            "stock"=> "required",
        ]);


        $request_data = $request->except(['image']);

        if($request->image) {

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if

        $product = Product::create($request_data);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('products.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view("dashboard.products.edit", compact("categories","product"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "name"=> "required",
            "description"=> "required",
            "category_id" =>"required",
            "purchase_price" =>"required",
            "sale_price" =>"required",
            "stock"=> "required",
        ]);


        $request_data = $request->except(['image']);

        if($request->image) {
            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if

        $product->update($request_data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);

        $product->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('products.index');
    }
}