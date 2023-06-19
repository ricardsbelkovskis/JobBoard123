<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diy;
use Illuminate\Support\Facades\Auth;

class DiyController extends Controller
{
    public function index()
    {
        $diys = Diy::all();

        return view('diys.index', ['diys' => $diys]);
    }

    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $form = new Diy();
        $form->title = $validatedData['title'];
        $form->description = $validatedData['description'];
        $form->user_id = auth()->id();
        $form->save();

        return redirect('/diy');
    }

    public function show(Diy $diy)
    {
        $diy->load('comments');
        $otherDiys = Diy::where('id', '!=', $diy->id)->latest()->take(5)->get();

        return view('diys.show', compact('diy', 'otherDiys'));
    }

    public function delete(Diy $diy)
    {
        $diy->delete();
         return redirect('/diy');
    }

    public function update(Request $request, Diy $diy)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $diy->update($request->only(['title', 'description']));

        return redirect()->route('diys.show', $diy)
            ->with('success', 'DIY post updated successfully');
    }

    public function addToFavorites(Diy $diy)
    {
        Auth::user()->favoriteDiys()->attach($diy);
        return redirect()
            ->back()
            ->with('success', 'Diy added to favorites successfully.');
    }

    public function removeFromFavorites(Diy $diy)
    {
        Auth::user()->favoriteDiys()->detach($diy);
        return redirect()
            ->back()
            ->with('success', 'Diy removed from favorites successfully.');
    }
}