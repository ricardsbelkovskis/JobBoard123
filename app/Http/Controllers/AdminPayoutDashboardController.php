<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cashout;
use Illuminate\Http\RedirectResponse;

class AdminPayoutDashboardController extends Controller
{
    public function dashboard()
    {
        $cashoutsPending = Cashout::where('status', 'pending')->get();
        $cashouts = Cashout::all();
        
        return view('admin.payouts', compact('cashoutsPending','cashouts'));
    }

    public function accept(Cashout $cashout): RedirectResponse
    {
        $cashout->status = 'accepted';
        $cashout->save();

        return redirect()->back()->with('success', 'Cashout accepted successfully.');
    }

    public function reject(Cashout $cashout): RedirectResponse
    {
        $cashout->status = 'rejected';
        $cashout->save();

        return redirect()->back()->with('success', 'Cashout rejected successfully.');
    }
}
