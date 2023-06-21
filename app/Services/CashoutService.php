<?php

namespace App\Services;

use App\Models\Cashout;
use App\Models\Purchase;

class CashoutService
{
    public function createCashout($userId, Purchase $purchase, $title, $bankAccount)
    {
        $existingCashout = Cashout::where('user_id', $userId)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'accepted')
            ->first();

        if ($existingCashout) {
            return [
                'success' => false,
                'message' => 'Cashout already exists for this purchase.',
            ];
        }

        $pendingCashout = Cashout::where('user_id', $userId)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingCashout) {
            return [
                'success' => false,
                'message' => 'A cashout request is already pending for this purchase.',
            ];
        }

        $rejectedCashout = Cashout::where('user_id', $userId)
            ->where('purchase_id', $purchase->id)
            ->where('status', 'rejected')
            ->first();

        if ($rejectedCashout) {
            $rejectedCashout->delete();
        }

        $siteFee = $purchase->hire->price * 0.1;
        $amount = $purchase->hire->price - $siteFee;
        $total = $amount;

        $cashout = new Cashout();
        $cashout->user_id = $userId;
        $cashout->purchase_id = $purchase->id;
        $cashout->title = $title;
        $cashout->amount = $amount;
        $cashout->fee = $siteFee;
        $cashout->total = $total;
        $cashout->status = 'pending';
        $cashout->bank_account = $bankAccount;
        $cashout->save();

        return [
            'success' => true,
            'message' => 'Cashout request submitted successfully.',
        ];
    }

    public function deleteCashout($cashoutId, $userId)
    {
        $cashout = Cashout::where('id', $cashoutId)
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->firstOrFail();

        $cashout->delete();

        return [
            'success' => true,
            'message' => 'Cashout request deleted successfully.',
        ];
    }

    public function getCashoutsByStatus($userId, $status)
    {
        return Cashout::where('user_id', $userId)
            ->where('status', $status)
            ->get();
    }
}
