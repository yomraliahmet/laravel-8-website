<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ContactRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'    => 'required|min:5',
            'email'    => 'required|min:5',
            'address' => 'required',
        ];
    }


    public function attributes()
    {
        return [
            'phone'    => trans('models.contact.phone'),
            'email'    => trans('models.contact.email'),
            'address'    => trans('models.contact.address'),
        ];
    }
}
