<?php

namespace Stellar\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $postsTable = config('stellar-cms.tables.posts', 'stellar_posts');

        return [
            'title' => ['required', 'string', 'max:255', Rule::unique($postsTable, 'title')],
            'body' => ['required', 'string', 'max:50000'],
            'save' => ['nullable'],
        ];
    }
}

