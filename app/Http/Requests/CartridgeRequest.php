<?php

namespace App\Http\Requests;

use App\Models\Color;
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
            'price' => ['required', 'integer', 'min:0', 'max:25600000'],
			'color_id' => ['required', 'integer', 'exists:colors,id'],
			'vendor_id' => ['sometimes', 'integer', 'exists:vendors,id'],
        ];
    }

	protected function prepareForValidation(): void
	{
		$this->merge([
			'color_id' => Color::whereTitle($this->color_title)->value('id'),
		]);
	}
}
