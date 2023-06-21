<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CashoutService;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class CashoutController extends Controller
{
    private $cashoutService;

    public function __construct(CashoutService $cashoutService)
    {
        $this->cashoutService = $cashoutService;
    }

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

        $cashoutsPending = $this->cashoutService->getCashoutsByStatus($user->id, 'pending');
        $cashoutsCompleted = $this->cashoutService->getCashoutsByStatus($user->id, 'accepted');
        $cashoutsRejected = $this->cashoutService->getCashoutsByStatus($user->id, 'rejected');

        return view('cashout.index', compact('purchases', 'amount', 'siteFee', 'cashoutsPending', 'cashoutsCompleted', 'cashoutsRejected'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $purchase = Purchase::findOrFail($request->input('purchase'));

        $response = $this->cashoutService->createCashout($user->id, $purchase, $request->input('title'), $request->input('account_number'));

        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function delete($id)
    {
        $user = Auth::user();

        $response = $this->cashoutService->deleteCashout($id, $user->id);

        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }
}
