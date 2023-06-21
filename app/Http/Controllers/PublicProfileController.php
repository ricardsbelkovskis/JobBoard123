<?php

namespace App\Http\Controllers;

use App\Services\PublicProfileService;

class PublicProfileController extends Controller
{
    protected $publicProfileService;

    public function __construct(PublicProfileService $publicProfileService)
    {
        $this->publicProfileService = $publicProfileService;
    }

    public function index($userId)
    {
        $data = $this->publicProfileService->getIndexData($userId);

        return view('publicProfile', $data);
    }
}
