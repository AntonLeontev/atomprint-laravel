<?php

namespace App\ValueObjects;

use App\Traits\Makeable;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use JsonSerializable;

class Price implements JsonSerializable
{
	use Makeable;

	private array $currencies = [
		'RUB' => '₽',
	];

	public function __construct(
		private readonly int $price,
		private readonly string $currency = 'RUB',
		private readonly int $precition = 100
	) 
	{
		if ($price < 0) {
			throw new InvalidArgumentException('Value must be greater than zero');
		}

		if (!isset($this->currencies[$currency])) {
			throw new InvalidArgumentException('This currency not allowed');
		}
	}

	public function raw(): int
	{
		return $this->price;
	}

	public function value(): float | int
	{
		return $this->price / $this->precition;
	}

	public function currency(): string
	{
		return $this->currency;
	}

	public function jsonSerialize(): mixed
	{
		return [
			'value' => $this->value(),
			'raw' => $this->raw(),
			'currency' => $this->currency(),
			'currencySimbol' => $this->currencySimbol(),
			'string' => $this->__toString(),
			'presition' => $this->precition
		];
		
	}

	protected function currencySimbol(): string
	{
		return $this->currencies[$this->currency];
	}

	public function __toString(): string
	{
		return number_format($this->price / $this->precition, 0, ',', ' ') . ' ' . $this->currencySimbol();
	}
}
