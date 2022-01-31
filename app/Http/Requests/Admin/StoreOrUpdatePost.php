<?php

namespace App\Http\Requests\Admin;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrUpdatePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'max:255',
            ],
            'slug' => [
                'required',
                Rule::unique('posts')->ignore($this->post),
                'max:255'
            ],
            'body' => [
                'required'
            ],
            'state' => [
                'required',
                Rule::in(PostStatus::getValues())
            ],
            'category' => [
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ]
        ];
    }
}
