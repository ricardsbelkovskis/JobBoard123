<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hire;

class AdminHireDashnoardController extends Controller
{
    public function hire_dashboard()
    {
        $hires = Hire::all();

        return view('admin.hires',compact('hires'));
    }

    public function deleteHire(Hire $hire)
    {
        $hire->delete();

        return redirect()->back()->with('success', 'Hire deleted successfully.');
    }
}
