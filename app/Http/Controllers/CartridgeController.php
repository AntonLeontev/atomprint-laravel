<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartridgeRequest;
use App\Models\Cartridge;
use Illuminate\Http\Request;

class CartridgeController extends Controller
{
    public function update(Cartridge $cartridge, CartridgeRequest $request)
	{
		$cartridge->updateOrFail($request->validated());

		return response()->json();
	}

	public function index()
	{
		$cartridges = Cartridge::with('color')->take(10)->simplePaginate(10);

		return response()->json($cartridges);
	}
}
