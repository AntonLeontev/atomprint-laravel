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
			->select([
				'id', 
				'title',
				'price_1', 
				'price_2', 
				'price_5', 
				'price_office', 
				'color_id', 
				'vendor_id'
				])
			->when($request->has('search'), function(Builder $query){
				$query->where('title', 'like', '%'.request('search').'%');
			})
			->when($request->has('vendor'), function(Builder $query){
				$query->whereIn('vendor_id', request('vendor'));
			})
			->when($request->has('color'), function(Builder $query){
				$query->whereIn('color_id', request('color'));
			})
			->when($request->has('sort'), function(Builder $query){
				$query->orderBy(request('sort'), request('order', 'ASC'));
			})
			->with(['color', 'vendor'])
			->simplePaginate(10)
			->withQueryString();

		return response()->json($cartridges);
	}
}
