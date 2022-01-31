<?php


namespace App\Http\Requests\Admin;


use App\Enums\AdminStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class AbstractAdmin extends FormRequest
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
            'active' => [
                Rule::in(AdminStatus::getValues())
            ]
        ];
    }
}
