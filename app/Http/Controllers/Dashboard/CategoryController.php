<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct(){
        $this->middleware(['permission:categories-read'])->only('index');
        $this->middleware(['permission:categories-create'])->only('create');
        $this->middleware(['permission:categories-update'])->only('edit');
        $this->middleware(['permission:categories-delete'])->only('destroy');
    }//end of _construct
    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($q) use ($request){
          return  $q->where('name','like','%'.$request->search.'%');
        })->latest()->paginate(5);
        return view("dashboard.categories.index", compact("categories"));
    }// end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        $category = Category::create($request->all());
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('categories.index');
    }// end of store



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required||unique:categories,name,'.$category->id
        ]);
        $category->update($request->all());
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('categories.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('categories.index');
    }
}//end of controller