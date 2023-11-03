<?php

namespace App\Http\Controllers;

use Ankurk91\LaravelShoppingCart\Facades\ShoppingCart;
use App\Models\Category;
use App\Models\Product;
use Darryldecode\Cart\Cart;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $latest_two_products = Product::latest()->take(2)->get();
        $new_products = Product::latest()->take(12)->get();
        $randomProduct = Product::inRandomOrder()->first();
        $count = ShoppingCart::count();
        return view("home", compact("products","categories","latest_two_products","randomProduct","new_products","count"));
    }
    public function products(Request $request)
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
         ->paginate(20);
         $count = ShoppingCart::count();
        return view("products", compact("categories","products","count"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $count = ShoppingCart::count();
        return view("singleproduct", compact("product","count"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}