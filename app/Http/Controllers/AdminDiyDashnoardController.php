<?php

namespace App\Http\Controllers;

use App\Models\Diy;
use Illuminate\Http\Request;

class AdminDiyDashnoardController extends Controller
{
    public function diy_dashboard()
    {
        $diy = Diy::all();

        return view('admin.diy',compact('diy'));
    }

    public function deleteDiy(Diy $diy)
    {
        $diy->delete();
        return redirect()->back()->with('success', 'DIY item deleted successfully.');
    }

    public function editDiy(Diy $diy)
    {
        return view('admin.edit-diy', compact('diy'));
    }

    public function updateDiy(Request $request, Diy $diy)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $diy->title = $request->input('title');
        $diy->description = $request->input('description');
        $diy->save();

        return redirect()->back()->with('success', 'DIY updated successfully.');
    }
}
