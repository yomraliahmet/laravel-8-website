<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\Request;

class UserRegisterRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname'    => 'required|min:2',
            'email'    => 'required|email|unique:users',
            'password'    => 'required',
        ];
    }


    public function attributes()
    {
        return [
            'fullname'    => trans('models.register.fullname'),
            'email'    => trans('models.register.email'),
            'password'    => trans('models.register.password'),
        ];
    }
}
