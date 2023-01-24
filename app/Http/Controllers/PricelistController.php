<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartridgeRequest;
use App\Models\Cartridge;
use App\Models\Color;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelReader;

class PricelistController extends Controller
{
    public function __invoke(Request $request)
	{
		$path = $request->file('file')->storePublicly('public/cartridges');

		$rowHeaders = [
			'title',
			'printers',
			'price_1',
			'price_2',
			'price_5',
			'price_office',
			'color_title',
			'vendor_title',
		];

		$rows = SimpleExcelReader::create(storage_path('app/'.$path))
			->useHeaders($rowHeaders)
			->getRows();

		foreach ($rows as $key => $row) {

			$rules = [
				'title' => ['required', 'string', 'between:2,150'],
				'printers' => ['required', 'string', 'between:2,65535'],
				'price_1' => ['required', 'integer', 'min:0', 'max:16777215'],
				'price_2' => ['required', 'integer', 'min:0', 'max:16777215'],
				'price_office' => ['required', 'integer', 'min:0', 'max:16777215'],
				'price_5' => ['required', 'integer', 'min:0', 'max:16777215'],
				'color_id' => ['required', 'integer', 'exists:colors,id'],
				'vendor_id' => ['sometimes', 'integer', 'exists:vendors,id'],
			];

			$row['color_id'] = Color::whereTitle($row['color_title'])->value('id');
			$row['vendor_id'] = Vendor::whereTitle($row['vendor_title'])->value('id');
			$row['printers'] = trim($row['printers']);

			$validator = Validator::make($row, $rules);

			if($validator->fails()) {
				echo sprintf('line %s - %s%s', $key+1, $validator->errors(), '<br>');
				continue;
			}

			Cartridge::firstOrCreate(['title' => $row['title']], $validator->validated());
		}
	}
}
