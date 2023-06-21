<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hire;
use App\Services\AdminHiresDashboardService;

class AdminHireDashnoardController extends Controller
{
    private $adminHireDashboardService;

    public function __construct(AdminHiresDashboardService $adminHireDashboardService)
    {
        $this->adminHireDashboardService = $adminHireDashboardService;
    }

    public function hire_dashboard()
    {
        $hires = $this->adminHireDashboardService->getAllHires();

        return view('admin.hires', compact('hires'));
    }

    public function deleteHire(Hire $hire)
    {
        $response = $this->adminHireDashboardService->deleteHire($hire);

        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }
}
