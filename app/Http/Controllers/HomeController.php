<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Diy;
use App\Models\Purchase;
use App\Models\Review;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $postCount = $user->posts()->count();
        $favoritesCount = $user->favorites()->count();
        $ListingCount = $user->hires()->count();
    
        // get the purchases related to the hires this user was hired for
        $hiredForPurchases = Purchase::whereHas('hire', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('hire.user')->get();
    
        $reviews = Review::all();
    
        $growthPercentage = $this->calculateGrowthPercentage($postCount);
    
        return view('home', [
            'user' => $user,
            'postCount' => $postCount,
            'favoritesCount' => $favoritesCount,
            'ListingCount' => $ListingCount,
            'growthPercentage' => $growthPercentage,
            'hiredForPurchases' => $hiredForPurchases,
            'reviews' => $reviews
        ]);
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

        $responseData = [
            'name' => $user->name,
        ];
    
        return response()->json($responseData);
    }
    

    public function getUserRole(User $user)
    {
        $postCount = $user->posts()->count();

        if ($postCount >= 10) {
            return 'Content Creator';
        } elseif ($postCount >= 5) {
            return 'Member';
        } else {
            return 'New';
        }
    }

    private function getPostCountForMonth($month)
    {
        return Diy::whereMonth('created_at', $month->month)->count();
    }
    
    private function calculateGrowthPercentage($currentPostCount)
    {
        $previousMonth = now()->subMonth();
        $previousPostCount = $this->getPostCountForMonth($previousMonth);
    
        if ($previousPostCount != 0) {
            $growthPercentage = round((($currentPostCount - $previousPostCount) / $previousPostCount) * 100, 2);
        } else {
            $growthPercentage = 0;
        }
    
        return $growthPercentage;
    }

    public function showInvoice(Purchase $purchase)
    {
        if ($purchase->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        return view('invoice.show', compact('purchase'));
    }

    public function showHire(Purchase $purchase)
    {
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        return view('invoice.hire', compact('purchase'));
    }

    public function StatusUpdate(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        if ($purchase->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot update status. Purchase is already completed.');
        }

        $purchase->status = $request->input('status');
        $purchase->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function ReviewStore(Request $request)
    {
        $request->validate([
            'content' => 'required|min:5',
        ]);

        $user_id = auth()->id();

        $purchase = Purchase::where('user_id', $user_id)->where('status', 'completed')->first();

        $review = new Review();
        $review->user_id = $user_id;
        $review->hire_id = $purchase->hire_id;
        $review->content = $request->input('content');
        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
    

    public function publicProfile($userId)
    {
        $user = User::find($userId);
        if(!$user){
         abort(404);
        }

        $reviews = Review::all();

        return view('publicProfile', [
            'user' => $user,
            'reviews' => $reviews
        ]);
    }

}
