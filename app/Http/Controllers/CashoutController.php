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

        $existingCashout = Cashout::where('user_id', $user->id)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'accepted')
            ->first();
    
        if ($existingCashout) {
            return redirect()->back()->with('error', 'Cashout already exists for this purchase.');
        }
  
        $pendingCashout = Cashout::where('user_id', $user->id)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'pending')
            ->first();
    
        if ($pendingCashout) {
            return redirect()->back()->with('error', 'A cashout request is already pending for this purchase.');
        }
    
        $rejectedCashout = Cashout::where('user_id', $user->id)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'rejected')
            ->first();
    
        if ($rejectedCashout) {
            $rejectedCashout->delete();

        $siteFee = $purchase->hire->price * 0.1;
        $amount = $purchase->hire->price - $siteFee;
        $total = $amount;
        $bankAccount = $request->input('account_number');
    
        $cashout = new Cashout();
        $cashout->user_id = $user->id;
        $cashout->purchase_id = $purchase->id;
        $cashout->title = $request->input('title');
        $cashout->amount = $amount;
        $cashout->fee = $siteFee;
        $cashout->total = $total;
        $cashout->status = 'pending';
        $cashout->bank_account = $request->input('account_number');
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
