<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class SettingRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currency'    => 'required|min:2',
        ];
    }


    public function attributes()
    {
        return [
            'currency'    => trans('models.setting.currency'),
        ];
    }
}
