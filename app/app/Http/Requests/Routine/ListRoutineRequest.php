<?php

namespace App\Http\Requests\Routine;

use Illuminate\Foundation\Http\FormRequest;

class ListRoutineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'offset' => ['nullable', 'integer', 'min:0'],
            'sort' => ['nullable', 'in:random,asc,desc'],
            'search' => ['nullable', 'array'],
            'search.*' => ['string', 'max:255'],
            'rr' => ['nullable', 'boolean'],
            'time' => ['nullable', 'integer', 'min:1'],
            'start' => ['nullable', 'regex:/^\d{2}:\d{2}$/'],
            'end' => ['nullable', 'regex:/^\d{2}:\d{2}$/'],
            'user' => ['nullable', 'string', 'max:255'],
        ];
    }
}
