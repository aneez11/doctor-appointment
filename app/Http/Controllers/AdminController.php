<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::where('id','!=',Auth::user()->admin->id)->get();
        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone' => 'required',
            'address' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address
        ];
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole('admin');
        $admin = Admin::create($data);
        $admin->update(['user_id' => $user->id]);
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/admins', $image, $imageName);
            $admin->update(['photo' => asset('storage/admins/' . $imageName)]);
        }
        return redirect()->route('admins.index')->with('success', 'Admin added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('admins.show',compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Admin $admin): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone' => 'required',
            'address' => 'required'
        ]);
        if ($request->password != null) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address
        ];
        $admin->update($data);
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/admins', $image, $imageName);
            $admin->update(['photo' => asset('storage/admins/' . $imageName)]);
        }
        return redirect()->route('admins.show', $admin->id)->with('success', ' Admin Details Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->user()->delete();
        $admin->delete();
        return redirect()->route('admins.index')->with('success','Admin Deleted Successfully');
    }
}
