<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screen;

class ScreenController extends Controller
{
    public function index()
    {
        $screens = Screen::all();
        return view('screens.index', compact('screens'));
    }
}
