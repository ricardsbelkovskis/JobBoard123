<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUsersDashboardService
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function createUser($data)
    {
        $validatedData = $this->validateUserData($data);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->admin_role = $validatedData['admin_role'];
        $user->save();

        return [
            'success' => true,
            'message' => 'A new user-profile has been created successfully!',
        ];
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return [
            'success' => true,
            'message' => 'User deleted successfully.',
        ];
    }

    public function updateUser(User $user, $data)
    {
        $validatedData = $this->validateUserData($data, $user->id);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->admin_role = $validatedData['admin_role'];
        $user->save();

        return [
            'success' => true,
            'message' => 'User updated successfully.',
        ];
    }

    private function validateUserData($data, $ignoreUserId = null)
    {
        return validator($data, [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($ignoreUserId)],
            'password' => 'required|min:8|confirmed',
            'admin_role' => 'required',
        ])->validate();
    }
}
