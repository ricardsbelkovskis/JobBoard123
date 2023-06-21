<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\HomeService;
use App\Models\Purchase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->middleware('auth');
        $this->homeService = $homeService;
    }

    public function index()
    {
        $user = Auth::user();
        $homeData = $this->homeService->getHomeData($user);

        return view('home', $homeData);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'description' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->description = $validatedData['description'];

        if ($validatedData['password']) {
        $user->password = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function showInvoice(Purchase $purchase)
    {
        if (!$this->homeService->isUserAuthorized($purchase)) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        return view('invoice.show', compact('purchase'));
    }

    public function showHire(Purchase $purchase)
    {
        if (!$this->homeService->isUserLoggedIn()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        return view('invoice.hire', compact('purchase'));
    }

    public function statusUpdate(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        if ($this->homeService->isPurchaseCompleted($purchase)) {
            return redirect()->back()->with('error', 'Cannot update status. Purchase is already completed.');
        }

        $status = $request->input('status');
        $this->homeService->updatePurchaseStatus($purchase, $status);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}
