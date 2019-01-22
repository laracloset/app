<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategory extends FormRequest
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
            'name' => [
                'required',
                'max:255',
            ],
            'slug' => [
                'required',
                Rule::unique('categories')->ignore($this->category),
                'max:255',
            ],
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                }),
            ],
        ];
    }
}
