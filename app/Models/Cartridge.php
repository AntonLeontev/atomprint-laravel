<?php

namespace App\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartridge extends Model
{
    use HasFactory;

	protected $fillable = [
		'title',
		'slug',
		'color_id',
		'price',
		'vendor_id',
	];

	protected $casts = [
		'price' => PriceCast::class,
	];

	public function printers()
	{
		return $this->belongsToMany(Printer::class);
	}

	public function color()
	{
		return $this->belongsTo(Color::class);
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class);
	}

	protected static function booted()
    {
        static::creating(function ($cartridge) {
            if(!empty($cartridge->slug)) {
				return;
			}

			$cartridge->slug = str($cartridge->title)->slug()->value();
        });
    }
}
