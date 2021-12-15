<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AdminRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
        ];

        if(!in_array("PUT",$this->route()->methods)){
            $rules["password"] = 'required';
            $rules["email"] = 'required|email|unique:admins,email';
        }else{
            $rules["email"] = 'required|email|unique:admins,email,'.$this->route("admin")->id;

        }

        if(in_array($this->route()->getAction("as"), ["admin.admin.update","admin.admin.store"])){
            $rules["roles"] = 'required';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'email'     => trans('models.admin.email'),
            'name'      => trans('models.admin.name'),
            'password'  => trans('models.admin.password'),
            'roles'     => trans('models.admin.roles'),
        ];
    }
}
