<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Vendor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
		$vendors = Vendor::all('id', 'title');
		$colors = Color::all('id', 'title');

        return view('welcome', compact('vendors', 'colors'));
    }
}
