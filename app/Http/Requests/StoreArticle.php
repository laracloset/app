<?php

namespace App\Http\Requests;

use App\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use MongoDB\Driver\Query;

class StoreArticle extends FormRequest
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
                Rule::unique('articles')->ignore($this->article),
                'max:255'
            ],
            'body' => [
                'required'
            ],
            'state' => [
                'required',
                Rule::in(array_keys(Article::getAvailableStates()))
            ],
            'category' => [
                'present',
//                'nullable',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ]
        ];
    }
}
