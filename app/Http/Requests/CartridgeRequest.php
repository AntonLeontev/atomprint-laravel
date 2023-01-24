<?php

namespace App\Http\Requests;

use App\Models\Color;
use App\Models\Vendor;
use Illuminate\Foundation\Http\FormRequest;

class CartridgeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'between:2,150'],
            'printers' => ['required', 'string', 'between:2,65535'],
            'price_1' => ['required', 'integer', 'min:0', 'max:25600000'],
            'price_2' => ['required', 'integer', 'min:0', 'max:25600000'],
            'price_5' => ['required', 'integer', 'min:0', 'max:25600000'],
            'price_office' => ['required', 'integer', 'min:0', 'max:25600000'],
			'color_id' => ['required', 'integer', 'exists:colors,id'],
			'vendor_id' => ['sometimes', 'integer', 'exists:vendors,id'],
        ];
    }

	protected function prepareForValidation(): void
	{
		$this->merge([
			'color_id' => Color::whereTitle($this->color_title)->value('id'),
		]);

		if ($this->has('vendor_title')) {
			$this->merge([
				'vendor_id' => Vendor::whereTitle($this->vendor_title)->value('id'),
			]);
		}
	}
}
