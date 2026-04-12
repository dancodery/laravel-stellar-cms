<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:posts,title'],
            'body' => ['required', 'string', 'max:50000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'This title has already been taken.',
            'body.required' => 'Please enter content.',
            'body.max' => 'The content is too long.',
        ];
    }
}
