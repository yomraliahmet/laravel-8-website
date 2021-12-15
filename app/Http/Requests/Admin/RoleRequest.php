<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class RoleRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route("role")->id ?? '';

        return [
            'name'     => 'required|distinct|min:2|unique:roles,name,'.$id,
            'name.*'     => 'required|distinct|min:2|unique:roles,name,'.$id,
            'guard_name'     => 'required',
        ];

    }


    public function attributes()
    {
        return [
            'name'          => trans('models.role.name'),
            'name.*'        => trans('models.role.name'),
            'guard_name'    => trans('models.role.guard_name'),
        ];
    }
}
