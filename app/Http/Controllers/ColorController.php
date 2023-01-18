<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
	{
		$colors = Color::all('id', 'title', 'thumbnail');
		
	  	return response()->json($colors);
	}
}
