<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Diy;
use Illuminate\Support\Facades\Auth;

class DiyService
{
    public function getAllDiys()
    {
        return Diy::all();
    }

    public function storeDiy(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $diy = new Diy();
        $diy->title = $validatedData['title'];
        $diy->description = $validatedData['description'];
        $diy->user_id = Auth::id();
        $diy->save();

        return [
            'success' => true,
            'message' => 'Diy created successfully',
            'diy' => $diy,
        ];
    }

    public function getDiyWithComments(Diy $diy)
    {
        $diy->load('comments');
        return $diy;
    }

    public function deleteDiy(Diy $diy)
    {
        $diy->delete();
        return [
            'success' => true,
            'message' => 'Diy deleted successfully',
        ];
    }

    public function updateDiy(Request $request, Diy $diy)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $diy->update($validatedData);

        return [
            'success' => true,
            'message' => 'Diy updated successfully',
            'diy' => $diy,
        ];
    }

    public function addToFavorites(Diy $diy)
    {
        Auth::user()->favoriteDiys()->attach($diy);
        return [
            'success' => true,
            'message' => 'Diy added to favorites successfully',
        ];
    }

    public function removeFromFavorites(Diy $diy)
    {
        Auth::user()->favoriteDiys()->detach($diy);
        return [
            'success' => true,
            'message' => 'Diy removed from favorites successfully',
        ];
    }
}
