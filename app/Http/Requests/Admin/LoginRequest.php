<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email|exists:admins,email',
            'password' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'email'    => trans('admin.login.email'),
            'password' => trans('admin.login.password'),
        ];
    }
}
