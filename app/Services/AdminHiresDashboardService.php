<?php

namespace App\Services;

use App\Models\Hire;

class AdminHiresDashboardService
{
    public function getAllHires()
    {
        return Hire::all();
    }

    public function deleteHire(Hire $hire)
    {
        $hire->delete();

        return [
            'success' => true,
            'message' => 'Hire deleted successfully.',
        ];
    }
}
