<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminDiyRequest;
use App\Models\Diy;
use Illuminate\Http\Request;
use App\Services\AdminDiyDashboardService;

class AdminDiyDashnoardController extends Controller
{
    private $diyDashboardService;

    public function __construct(AdminDiyDashboardService $diyDashboardService)
    {
        $this->diyDashboardService = $diyDashboardService;
    }

    public function diy_dashboard()
    {
        $diy = $this->diyDashboardService->getAllDiyItems();

        return view('admin.diy', compact('diy'));
    }

    public function deleteDiy(Diy $diy)
    {
        $this->diyDashboardService->deleteDiyItem($diy);

        return redirect()->back()->with('success', 'DIY item deleted successfully.');
    }

    public function editDiy(Diy $diy)
    {
        return view('admin.edit-diy', compact('diy'));
    }

    public function updateDiy(AdminDiyRequest $request, Diy $diy)
    {
        $validatedData = $request->validated();

        $this->diyDashboardService->updateDiyItem($diy, $validatedData);

        return redirect()->back()->with('success', 'DIY updated successfully.');
    }
}
