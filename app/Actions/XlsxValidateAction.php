<?php

namespace App\Actions;

use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelReader;

class XlsxValidateAction
{
	private array $errors = [];

	public function validate(string $path): void
	{
		$rows = SimpleExcelReader::create(storage_path('app/'.$path))
			->useHeaders($this->headers())
			->getRows();

		foreach ($rows as $key => $row) {
			$validator = Validator::make($row, $this->rules());

			if($validator->fails()) {
				$message = '';

				foreach ($validator->errors()->all() as $error) {
					$message .= $error . ' ';
				}

				$this->errors[] = sprintf('Строка %s: %s', $key+2, trim($message));
				continue;
			}
		}
	}	

	public function getErrors(): array
	{
		return $this->errors;
	}

	public function fails(): bool
	{
		return !empty($this->errors);
	}

	private function rules(): array
	{
		return [
			'title' => ['required', 'string', 'between:2,150'],
			'printers' => ['required', 'string', 'between:2,65535'],
			'price_1' => ['required', 'integer', 'min:0', 'max:16777215'],
			'price_2' => ['required', 'integer', 'min:0', 'max:16777215'],
			'price_office' => ['required', 'integer', 'min:0', 'max:16777215'],
			'price_5' => ['required', 'integer', 'min:0', 'max:16777215'],
			'color_title' => ['required', 'string', 'exists:colors,title'],
			'vendor_title' => ['required', 'string', 'exists:vendors,title'],
		];
	}

	private function headers(): array
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
