<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartridgeRequest;
use App\Models\Cartridge;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
				'cartridges.id', 
				'cartridges.title', 
				'cartridges.printers', 
				'cartridges.price_1', 
				'cartridges.price_2', 
				'cartridges.price_5', 
				'cartridges.price_office', 
				DB::raw('colors.title AS color_title'),
				DB::raw('vendors.title AS vendor_title'),
			])
			->join('colors', 'cartridges.color_id', 'colors.id')
			->join('vendors', 'cartridges.vendor_id', 'vendors.id')
			->when($request->has('search'), function(Builder $query){
				$query->where(function($query){
					$query->where('cartridges.title', 'like', '%'.request('search').'%')
						->orWhere('cartridges.printers', 'like', '%'.request('search').'%');
				});
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
			->simplePaginate()
			->withQueryString();

		return response()->json($cartridges);
	}
}
