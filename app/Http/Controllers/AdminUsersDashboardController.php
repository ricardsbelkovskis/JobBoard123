<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminUsersDashboardService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUsersDashboardController extends Controller
{
    private $adminUsersDashboardService;

    public function __construct(AdminUsersDashboardService $adminUsersDashboardService)
    {
        $this->adminUsersDashboardService = $adminUsersDashboardService;
    }

    public function users_dashboard()
    {
        $users = $this->adminUsersDashboardService->getAllUsers();

        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $response = $this->adminUsersDashboardService->createUser($request->all());

        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function destroyUser(User $user)
    {
        $response = $this->adminUsersDashboardService->deleteUser($user);

        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function editUser(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $response = $this->adminUsersDashboardService->updateUser($user, $request->all());

        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }
}
