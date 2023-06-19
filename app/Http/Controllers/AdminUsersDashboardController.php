<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 

class AdminUsersDashboardController extends Controller
{
    public function users_dashboard()
    {
        $users = User::all();
    
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'admin_role' => 'required',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->admin_role = $request->input('admin_role');
        $user->save();

        return redirect()->back()->with('success', 'A new user-profile has been created successfully!');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    
    public function editUser(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'admin_role' => 'required',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->admin_role = $request->input('admin_role');
        $user->save();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
