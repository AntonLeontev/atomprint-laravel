<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

	protected $fillable = [
		'title',
		'slug',
		'vendor_id',
	];

	public function cartridges()
	{
		return $this->belongsToMany(Cartridge::class);
	}
	
	public function vendor()
	{
		return $this->belongsTo(Vendor::class);
	}

	protected static function booted()
    {
        static::creating(function ($printer) {
            if(!empty($printer->slug)) {
				return;
			}

			$printer->slug = str($printer->title)->slug()->value();
        });
    }
}
