<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminPayoutDashboardService;
use App\Models\Cashout;
use Illuminate\Http\RedirectResponse;

class AdminPayoutDashboardController extends Controller
{
    private $adminPayoutDashboardService;

    public function __construct(AdminPayoutDashboardService $adminPayoutDashboardService)
    {
        $this->adminPayoutDashboardService = $adminPayoutDashboardService;
    }

    public function dashboard()
    {
        $cashoutsPending = $this->adminPayoutDashboardService->getPendingCashouts();
        $cashouts = $this->adminPayoutDashboardService->getAllCashouts();
        
        return view('admin.payouts', compact('cashoutsPending', 'cashouts'));
    }

    public function accept(Cashout $cashout): RedirectResponse
    {
        $response = $this->adminPayoutDashboardService->acceptCashout($cashout);

        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function reject(Cashout $cashout): RedirectResponse
    {
        $response = $this->adminPayoutDashboardService->rejectCashout($cashout);

        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }
}
