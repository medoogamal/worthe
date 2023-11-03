<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Dotenv\Store\File\Reader;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->middleware(['permission:users-read'])->only('index');
        $this->middleware(['permission:users-create'])->only('create');
        $this->middleware(['permission:users-update'])->only('edit');
        $this->middleware(['permission:users-delete'])->only('destroy');
    }//end of _construct
    public function index(Request $request )
    {
         $clients = User::whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['admin', 'super_admin']);
        })->when($request->search, function ($q) use ($request){
            return  $q->where('first_name','like','%'.$request->search.'%');
          })->latest()->paginate(5);
          return view("dashboard.clients.index", compact("clients"));

    }//end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.clients.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         "name"=> "required",
    //         "phone" => "required",
    //         "address" => "required"
    //     ]);

    //     $client = Client::create($request->all());
    //     session()->flash('success',__('site.added_successfully'));
    //     return redirect()->route('clients.index');
    // }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Client $client)
    // {
    //     return view('dashboard.clients.edit', compact('client'));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Client $client)
    // {
    //     $request->validate([
    //         "name"=> "required",
    //         "phone" => "required",
    //         "address" => "required"
    //     ]);

    //     $client->update($request->all());
    //     session()->flash('success',__('site.updated_successfully'));
    //     return redirect()->route('clients.index');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $client)
    {
        $client->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('clients.index');
    }
}
