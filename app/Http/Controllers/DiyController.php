<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiyService;
use App\Models\Diy;
use App\Http\Requests\DiyRequest;


class DiyController extends Controller
{
    private $diyService;

    public function __construct(DiyService $diyService)
    {
        $this->diyService = $diyService;
    }

    public function index()
    {
        $diys = $this->diyService->getAllDiys();

        return view('diys.index', ['diys' => $diys]);
    }

    public function submit(Request $request)
    {
        $response = $this->diyService->storeDiy($request);

        if ($response['success']) {
            return response()->json([
                'route' => route('diys.show', $response['diy']),
                'diy' => [
                    'title' => $response['diy']->title,
                    'user' => [
                        'name' => $response['diy']->user->name,
                    ],
                    'created_at' => $response['diy']->created_at->diffForHumans(),
                ],
            ]);
        } else {
            return response()->json(['error' => 'Failed to submit DIY']);
        }
    }

    public function show(Diy $diy)
    {
        $diy = $this->diyService->getDiyWithComments($diy);
        $otherDiys = Diy::where('id', '!=', $diy->id)->latest()->take(5)->get();

        return view('diys.show', compact('diy', 'otherDiys'));
    }

    public function delete(Diy $diy)
    {
        $response = $this->diyService->deleteDiy($diy);

        if ($response['success']) {
            return redirect('/diy')->with('success', $response['message']);
        } else {
            return redirect('/diy')->with('error', $response['message']);
        }
    }

    public function update(DiyRequest $request, Diy $diy)
    {
        $validatedData = $request->validated();

        $response = $this->diyService->updateDiy($request, $diy);

        if ($response['success']) {
            return redirect()->route('diys.show', $diy)
                ->with('success', $response['message']);
        } else {
            return redirect()->route('diys.show', $diy)
                ->with('error', $response['message']);
        }
    }

    public function addToFavorites(Diy $diy)
    {
        $response = $this->diyService->addToFavorites($diy);

        if ($response['success']) {
            return redirect()->back()->with('success', $response['message']);
        } else {
            return redirect()->back()->with('error', $response['message']);
        }
    }

    public function removeFromFavorites(Diy $diy)
    {
        $response = $this->diyService->removeFromFavorites($diy);

        if ($response['success']) {
            return redirect()->back()->with('success', $response['message']);
        } else {
            return redirect()->back()->with('error', $response['message']);
        }
    }
}
