<?php

namespace App\Http\Controllers;

use Ankurk91\LaravelShoppingCart\Facades\ShoppingCart;
use App\Models\Product;
use Darryldecode\Cart\Cart;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request){
        $cartCollection = ShoppingCart::all();
        $total_price = ShoppingCart::subtotal();
        $count = ShoppingCart::count();
        $user = auth()->user();
        return view("cart", compact("cartCollection","total_price","count","user"));
    }
    public function store(Request $request){
        $request->validate([
            "quantity"=> "required",
        ]);
        $product = Product::findOrFail($request->input("product_id"));
        // Cart::session(auth()->user()->id);
        // // array format
        // Cart::add(array(
        //     'id' => , // inique row ID
        //     'name' => $product->name,
        //     'price' => $product->sale_price,
        //     'quantity' => ,
        // ));

        $item = ShoppingCart::add(
            $product->id,
            $product->name,
            $product->sale_price,
            $request->input('quantity'),
        );

        return redirect()->back()->with('success','added to cart successfully');
    }

    public function checkout (Request $request){
        $request->validate([
            'product_ids' => 'required|array',
            'quantities' => 'required|array',
        ]);

        $user = auth()->user();

        $order = $user->orders()->create([]);
        //use the auth or user that logged in  use after that

        $total_price = 0;



        foreach ($request->product_ids as $index=>$product_id) {
                $product = Product::findOrfail($product_id);

                $total_price += ($product->sale_price * $request->quantities[$index]);

                $order->products()->attach($product_id,['quantity' => $request->quantities[$index]]);

                $product->update([
                    'stock'=> $product->stock - $request->quantities[$index],
                ]);
        }
        // dd($request->all());

        $order->update([
            'total_price'=> $total_price,
        ]);

        ShoppingCart::clear();
        return redirect()->route('cart.index');
    }
    public function destroy(Request $request,$id){
        ShoppingCart::remove($id);
        return redirect()->route('cart.index');
    }
}