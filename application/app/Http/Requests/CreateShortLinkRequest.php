<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShortLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => ['required', 'url'],
            'ttl' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
