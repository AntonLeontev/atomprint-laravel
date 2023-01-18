<?php

namespace App\Http\Controllers;

use App\Models\Cartridge;
use Illuminate\Http\Request;

class CartridgeController extends Controller
{
    public function update(Cartridge $cartridge)
	{
		
	}

	public function index()
	{
		$cartridges = Cartridge::with('color')->take(10)->get(['id', 'color_id', 'title', 'price']);

		return response()->json($cartridges);
	}
}
