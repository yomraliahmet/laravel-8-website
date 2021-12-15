<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class MenuRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tr.name'    => 'required|min:5',
            'en.name'    => 'required|min:5',
            'permission' => 'required',
            'icon' => 'required',
        ];
    }


    public function attributes()
    {
        return [
            'tr.name'    => trans('models.menu.name'),
            'en.name'    => trans('models.menu.name'),
            'permission' => trans('models.menu.permission'),
            'icon' => trans('models.menu.icon'),
        ];
    }

}
