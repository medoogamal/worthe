<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->middleware(['permission:orders-read'])->only('index');
        $this->middleware(['permission:orders-create'])->only('create');
        $this->middleware(['permission:orders-update'])->only('edit');
        $this->middleware(['permission:orders-delete'])->only('destroy');
    }//end of _construct
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        $categories = Category::with("products")->get();
        $orders = $user->orders()->with("products")->paginate(5);
        return view("dashboard.clients.orders.create", compact("user","categories","orders"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,User $user)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'quantities' => 'required|array',
        ]);

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

        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client,Order $order)
    {
        $orders = $client->orders()->with("products")->paginate(5);
        $categories = Category::with('products')->get();
        return view("dashboard.clients.orders.edit", compact("client","order","categories","orders"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Client $client, Order $order )
    {

        $request->validate([
            'product_ids' => 'required|array',
            'quantities' => 'required|array',
        ]);

        foreach ($order->products as $product) {
            $product->update([
                "stock" => $product->stock + $product->pivot->quantity,
            ]);
        }
        $order->delete();

        $order = $client->orders()->create([]);
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

        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order,Client $client)
    {
        //
    }
}
