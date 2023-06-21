<?php

namespace App\Services;

use App\Models\Diy;

class AdminDiyDashboardService
{
    public function getAllDiyItems()
    {
        return Diy::all();
    }

    public function deleteDiyItem(Diy $diy)
    {
        $diy->delete();
    }

    public function updateDiyItem(Diy $diy, array $validatedData)
    {
        $diy->title = $validatedData['title'];
        $diy->description = $validatedData['description'];
        $diy->save();
    }
}
