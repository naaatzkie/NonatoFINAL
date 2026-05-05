<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLostItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'item_name'          => 'required|string|max:255',
            'category'           => 'required|string|max:100',
            'brand'              => 'nullable|string|max:100',
            'color'              => 'required|string|max:100',
            'date_lost'          => 'required|date',
            'last_seen_location' => 'required|string|max:255',
            'description'        => 'nullable|string|max:1000',
            'image'              => 'nullable|image|max:2048',
        ];
    }
}
