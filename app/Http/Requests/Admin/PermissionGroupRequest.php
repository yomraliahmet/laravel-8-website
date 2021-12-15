<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PermissionGroupRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(in_array("PUT",$this->route()->methods)){
            $model = $this->route("permission_group")->load(["permissions","translations"]);

            $rules = [
                'tr.name'    => 'required|min:2|unique:permission_group_translations,name,'.$model->translate("tr")->id,
                'en.name'    => 'required|min:2|unique:permission_group_translations,name,'.$model->translate("en")->id,
                'guard_name'     => 'required',
            ];
            $rules["name.*"] = 'required|min:2|unique:permissions,name';
            foreach ($model->permissions as $key => $permission){
                if(in_array($permission->name,$this->input("name"))){
                    $rules["name.". $key] = 'required|min:2|unique:permissions,name,'.$permission->id;
                }

            }
            return $rules;
        }else{
            $rules = [
                'tr.name'    => 'required|min:2|unique:permission_group_translations,name',
                'en.name'    => 'required|min:2|unique:permission_group_translations,name',
                'name.*'     => 'required|min:2|unique:permissions,name',
                'guard_name'     => 'required',
            ];
        }

        return $rules;
    }


    public function attributes()
    {
        return [
            'tr.name'       => trans('models.permission-group.name'),
            'en.name'       => trans('models.permission-group.name'),
            'name.*'        => trans('models.permission-group.permission'),
            'guard_name'    => trans('models.permission-group.guard_name'),
        ];
    }
}
