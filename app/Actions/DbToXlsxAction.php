<?php

namespace App\Actions;

use App\Models\Cartridge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Spatie\SimpleExcel\SimpleExcelWriter;

final class DbToXlsxAction
{
	public function __invoke(LazyCollection $cartridges)
	{
		$writer = SimpleExcelWriter::streamDownload($this->filename());

		$writer->addHeader($this->header());
		
		$i = 0;
		foreach ($cartridges as $cartridge) {
			$writer->addRow($cartridge->toArray());
			$i++;

			if ($i % 500 === 0) {
				flush();
			}
		}

		$writer->toBrowser();
	}

	private function header(): array
	{
		return [
			'Бренд',
			'Картридж',
			'Цена за 1',
			'Цена за 2',
			'Цена за 5',
			'Цена офис',
			'Цвет',
			'Принтеры',
		];
	}

	private function filename(): string
	{
		return sprintf('price_%s.xlsx', now()->setTimezone(5)->format('Y-m-d_H-i'));
	}
}
