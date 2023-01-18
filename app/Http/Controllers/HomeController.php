<?php

namespace App\Http\Controllers;

use App\Models\Cartridge;
use App\Models\Color;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
		$cartridges = Cartridge::with('color')->get();
		$colors = Color::all();

        return view('welcome', compact(['cartridges', 'colors']));
    }
}
