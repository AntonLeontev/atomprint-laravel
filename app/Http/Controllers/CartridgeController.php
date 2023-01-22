<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartridgeRequest;
use App\Models\Cartridge;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CartridgeController extends Controller
{
    public function update(Cartridge $cartridge, CartridgeRequest $request)
	{
		$cartridge->updateOrFail($request->validated());

		return response()->json(['ok' => true]);
	}

	public function index(Request $request)
	{
		$cartridges = Cartridge::query()
			->when($request->has('vendor'), function(Builder $query){
				$query->whereIn('vendor_id', request('vendor'));
			})
			->when($request->has('color'), function(Builder $query){
				$query->whereIn('color_id', request('color'));
			})
			->with('color')
			->simplePaginate(10)
			->withQueryString();

		return response()->json($cartridges);
	}
}
