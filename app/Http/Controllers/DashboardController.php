<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $apartments = Auth::user()->apartments()->get();
        return view('dashboard', compact('apartments'));
    }
}
