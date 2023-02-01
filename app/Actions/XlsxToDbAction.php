<?php

namespace App\Actions;

use App\Models\Cartridge;
use App\Models\Color;
use App\Models\Vendor;
use Spatie\SimpleExcel\SimpleExcelReader;

class XlsxToDbAction
{
	public function save(string $path)
	{
		$rows = SimpleExcelReader::create(storage_path('app/'.$path))
			->useHeaders($this->headers())
			->getRows();

		foreach ($rows as $row) {
			$row['color_id'] = Color::whereTitle($row['color_title'])->value('id');
			$row['vendor_id'] = Vendor::whereTitle($row['vendor_title'])->value('id');
			$row['printers'] = trim($row['printers']);

			Cartridge::updateOrCreate(['title' => $row['title']], $row);
		}
	}

	public function headers(): array
	{
		return [
			'title',
			'printers',
			'price_1',
			'price_2',
			'price_5',
			'price_office',
			'color_title',
			'vendor_title',
		];
	}
}
