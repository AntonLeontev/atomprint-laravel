<?php

namespace App\ViewModels;

use App\Models\Cartridge;
use Illuminate\Support\Facades\DB;

class CartridgeViewModel
{
	public function index()
	{
		return Cartridge::query()
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
			->search()
			->filter()
			->sort()
			->simplePaginate()
			->withQueryString();
	}
}
