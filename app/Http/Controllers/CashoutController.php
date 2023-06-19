<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Cashout;
use Illuminate\Support\Facades\Auth;

class CashoutController extends Controller
{
    public function index()
    {
        return view('cashout.index');
    }

    public function create()
    {
        $user = Auth::user();
        $purchases = Purchase::whereHas('hire', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        $amount = 0;
        $siteFee = 0;
        
        $cashoutsPending = Cashout::where('user_id', $user->id)->where('status', 'pending')->get();
        $cashoutsCompleted = Cashout::where('user_id', $user->id)->where('status', 'accepted')->get();
        $cashoutsRejected = Cashout::where('user_id', $user->id)->where('status', 'rejected')->get();
    
        return view('cashout.index', compact('purchases', 'amount', 'siteFee', 'cashoutsPending', 'cashoutsCompleted','cashoutsRejected'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $purchase = Purchase::findOrFail($request->input('purchase'));
    
        // Check if there is an accepted cashout for the given purchase and user
        $existingCashout = Cashout::where('user_id', $user->id)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'accepted')
            ->first();
    
        if ($existingCashout) {
            return redirect()->back()->with('error', 'Cashout already exists for this purchase.');
        }
    
        // Check if there is a pending cashout for the given purchase and user
        $pendingCashout = Cashout::where('user_id', $user->id)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'pending')
            ->first();
    
        if ($pendingCashout) {
            return redirect()->back()->with('error', 'A cashout request is already pending for this purchase.');
        }
    
        // Check if there is a rejected cashout for the given purchase and user
        $rejectedCashout = Cashout::where('user_id', $user->id)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'rejected')
            ->first();
    
        if ($rejectedCashout) {
            $rejectedCashout->delete(); // Delete the rejected cashout to allow the user to create a new one
        }
    
        // Rest of your code...
        $siteFee = $purchase->hire->price * 0.1; // Calculate the site fee (10%)
        $amount = $purchase->hire->price - $siteFee;
        $total = $amount; // Total is the same as the amount
        $bankAccount = $request->input('account_number'); // Get the bank account from the request
    
        $cashout = new Cashout();
        $cashout->user_id = $user->id;
        $cashout->purchase_id = $purchase->id;
        $cashout->title = $request->input('title');
        $cashout->amount = $amount;
        $cashout->fee = $siteFee;
        $cashout->total = $total;
        $cashout->status = 'pending'; // Set the status to "pending"
        $cashout->bank_account = $request->input('account_number'); // Set the bank account
        $cashout->save();
    
        return redirect()->back()->with('success', 'Cashout request submitted successfully.');
    }
    
    

    public function delete($id)
    {
        $user = Auth::user();
        $cashout = Cashout::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $cashout->delete();

        return redirect()->back()->with('success', 'Cashout request deleted successfully.');
    }
    
     
}
