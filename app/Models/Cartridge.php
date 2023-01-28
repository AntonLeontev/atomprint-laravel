<?php

namespace App\Models;

use App\Casts\PriceCast;
use App\QueryBuilders\CartridgeQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartridge extends Model
{
    use HasFactory;

	protected $fillable = [
		'title',
		'printers',
		'price_1',
		'price_2',
		'price_5',
		'price_office',
		'color_id',
		'vendor_id',
	];

	protected $casts = [
		'price_1' => PriceCast::class,
		'price_2' => PriceCast::class,
		'price_5' => PriceCast::class,
		'price_office' => PriceCast::class,
	];
	
	public function newEloquentBuilder($query)
	{
		return new CartridgeQueryBuilder($query);
	}

	public function color()
	{
		return $this->belongsTo(Color::class);
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class);
	}
}
