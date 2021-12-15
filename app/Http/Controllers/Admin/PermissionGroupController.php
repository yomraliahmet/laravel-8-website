<?php

namespace App\Http\Controllers\Admin;

use App\Datatables\Admin\PermissionGroupDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionGroupRequest;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;

class PermissionGroupController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $table = (new PermissionGroupDatatable())->table();

        return view("admin.crud.index")
            ->with("title", trans("admin.permission-group.title"))
            ->with("table", $table);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $buttons = [
            \Button::backButton(route("admin.permission-group.index"),["admin.permission-group.index"]),
            \Button::ajaxSubmitButton("form",["admin.permission-group.store"])
        ];

        $guardKeys = array_keys(config("auth.guards"));
        $guards = array_combine($guardKeys, $guardKeys);

        return view("admin.permission-group.create")
            ->with("buttons", $buttons)
            ->with("guards", $guards)
            ->with("title",trans("admin.permission-group.new_title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionGroupRequest $request)
    {
        $model = new PermissionGroup();
        $model->fill($request->except(["guard_name","name","_token"]));
        $model->save();

        foreach ($request->input("name") as $name){
            $model->permissions()->create([
                "name" => $name,
                "guard_name" => $request->input("guard_name"),
            ]);
        }

        return response()->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param PermissionGroup $permission_group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(PermissionGroup $permission_group)
    {
        $buttons = [
            \Button::backButton(route("admin.permission-group.index"),["admin.permission-group.index"]),
            \Button::ajaxSubmitButton("form",["admin.permission-group.update"])
        ];

        $guardKeys = array_keys(config("auth.guards"));
        $guards = array_combine($guardKeys, $guardKeys);

        return view("admin.permission-group.edit")
            ->with("model", $permission_group->load("permissions"))
            ->with("buttons", $buttons)
            ->with("guards", $guards)
            ->with("title",trans("admin.permission-group.edit_title"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionGroupRequest $request, PermissionGroup $permission_group)
    {

        $permission_group->fill($request->except(["_method","_token","name","guard_name"]));
        $permission_group->save();

        foreach ($request->input("name") as $name){
            $permission_group->permissions()->updateOrCreate(["guard_name" => $request->input("guard_name"), "name" => $name]);
        }

        return response()->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionGroup $permission_group)
    {
        $permission_group->forceDelete();

        return response()->success();
    }

    public function selectedDestroy(Request $request)
    {
        PermissionGroup::query()->whereIn("id",$request->input("id"))->forceDelete();

        return response()->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable()
    {
        return (new PermissionGroupDatatable())->datatable();
    }
}
