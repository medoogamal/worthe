<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// require 'vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:users-read'])->only('index');
        $this->middleware(['permission:users-create'])->only('create');
        $this->middleware(['permission:users-update'])->only('edit');
        $this->middleware(['permission:users-delete'])->only('destroy');
    }//end of _construct

    public function index(Request $request)
    {

            $users = User::whereHasRole('admin')->where(function($q) use($request) {
               return $q->when($request->search, function($query) use ($request){
                    return $query->where('first_name','like','%' . $request->search . '%')
                        ->orWhere('last_name','like','%' . $request->search . '%');
                });
            })->latest()
            ->paginate(5);
            return view('dashboard.users.index', compact('users'));


    }//end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }//end of create

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email' => 'required|email',
            'image'=>'image',
            'password' => 'required|confirmed',
            'permissions'=> 'required:min:1'
        ]);

        $request_data = $request->except(['password','password_confirmation','permissions','image']);
        $request_data['password'] = bcrypt($request->password);

        if($request->image) {

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if


        $user = User::create($request_data);
        $user->addRole('admin');

            $user->syncPermissions($request->permissions);


            session()->flash('success',__('site.added_successfully'));
        return redirect()->route('users.index');
    }//end of store


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name'=> 'required',
            'last_name'=> 'required',
            'image'=>'image',
            'email' => 'required|email|unique:users,email'. $user->id,
        ]);

        $request_data = $request->except(['permissions','image']);

        if($request->image) {
            if($user->image !== 'default.png'){
                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if

        $user->update($request_data);
        if($request->permissions === null){
            $user->syncPermissions([]);
        }else{
            $user->syncPermissions($request->permissions);
        }




        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->image !== 'default.png'){
            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
        }
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('users.index');
    }//end of destroy
}