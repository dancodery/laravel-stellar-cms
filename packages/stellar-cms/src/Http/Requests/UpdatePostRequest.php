<?php

namespace Stellar\Cms\Http\Requests;

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
        $postsTable = config('stellar-cms.tables.posts', 'stellar_posts');
        $post = $this->route('post');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique($postsTable, 'title')->ignore($post?->id),
            ],
            'body' => ['required', 'string', 'max:50000'],
            'save' => ['nullable'],
        ];
    }
}

