<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HireService;
use App\Models\Hire;

class HireController extends Controller
{
    private $hireService;

    public function __construct(HireService $hireService)
    {
        $this->hireService = $hireService;
    }

    public function index()
    {
        $hires = $this->hireService->getAllHires();

        return view('hire.index', compact('hires'));
    }

    public function createForm()
    {
        return view('hire.create');
    }

    public function store(Request $request)
    {
        $response = $this->hireService->storeHire($request);

        if (!$response['success']) {
            return response()->json($response, 422);
        }

        return response()->json($response);
    }

    public function show(Hire $hire)
    {
        $photos = $this->hireService->getHirePhotos($hire);

        return view('hire.show', compact('hire', 'photos'));
    }

    public function payment(Hire $hire)
    {
        return $this->hireService->handlePayment($hire);
    }

    public function success(Request $request, Hire $hire)
    {
        return $this->hireService->handleSuccessPayment($request, $hire);
    }

    public function delete(Hire $hire)
    {
        $response = $this->hireService->deleteHire($hire);

        if (!$response['success']) {
            return redirect()->route('hire.index')->with('error', $response['message']);
        }

        return redirect()->route('hire.index')->with('success', $response['message']);
    }
}
