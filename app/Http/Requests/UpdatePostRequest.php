<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $post = $this->route('post');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts', 'title')->ignore($post?->id),
            ],
            'body' => ['required', 'string', 'max:50000'],
            'save' => ['nullable'],
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
