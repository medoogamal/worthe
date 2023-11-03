<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class Order2Controller extends Controller
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
    public function index(Request $request)
    {
        $orders = Order::whereHas('user',function ($q) use ($request){
            $q->when($request->search, function ($q) use ($request){
                return  $q->where('first_name','like','%'.$request->search.'%');
              });
        })->latest()->paginate(15);
        return view("dashboard.orders.index", compact("orders"));
    }


    public function products(Order $order){
        $products = $order->products()->get();
        $user = $order->user()->get();
        return view("dashboard.orders._products", compact("order","user","products"));
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        foreach ($order->products as $product) {
            $product->update([
                "stock" => $product->stock + $product->pivot->quantity,
            ]);
        }
        $order->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('orders.index');
    } // end of destroy
}