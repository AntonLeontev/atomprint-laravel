<?php

namespace App\Casts;

use App\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return Price::make($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if(!$value instanceof Price) {
			$value = Price::make($value);
		}

		return $value->raw();
    }
}
