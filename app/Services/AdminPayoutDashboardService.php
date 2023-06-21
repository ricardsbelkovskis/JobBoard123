<?php

namespace App\Services;

use App\Models\Cashout;

class AdminPayoutDashboardService
{
    public function getPendingCashouts()
    {
        return Cashout::where('status', 'pending')->get();
    }

    public function getAllCashouts()
    {
        return Cashout::all();
    }

    public function acceptCashout(Cashout $cashout)
    {
        $cashout->status = 'accepted';
        $cashout->save();

        return [
            'success' => true,
            'message' => 'Cashout accepted successfully.',
        ];
    }

    public function rejectCashout(Cashout $cashout)
    {
        $cashout->status = 'rejected';
        $cashout->save();

        return [
            'success' => true,
            'message' => 'Cashout rejected successfully.',
        ];
    }
}
