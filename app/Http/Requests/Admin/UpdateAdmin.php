<?php


namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateAdmin extends AbstractAdmin
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('admins')->ignore($this->admin),
                ],
                'password' => [
                    'nullable',
                    'min:6',
                    'confirmed',
                ],
            ]
        );
    }
}
