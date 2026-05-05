<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoundItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'item_name'   => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'brand'       => 'nullable|string|max:100',
            'color'       => 'required|string|max:100',
            'date_found'  => 'required|date',
            'time_found'  => 'required',
            'place_found' => 'required|string|max:255',
            'image'       => 'nullable|image|max:2048',
        ];
    }
}
