<?php

namespace App\Http\Controllers\Admin;

use App\Datatables\Admin\MenuDatatable;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class MenuController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $buttons = [
            \Button::backButton(route("admin.menu.index"),["admin.menu.index"]),
            \Button::ajaxSubmitButton("form",["admin.menu.store"])
        ];

/*
        if(Cache::has("dashboard_menu")) Cache::forget("dashboard_menu");
        $table = (new MenuDatatable())->table();

        return view("admin.crud.index")
            ->with("title", trans("admin.menu.title"))
            ->with("table", $table);
*/

        $routes = collect(\Route::getRoutes())->map(function ($route) {
            if($route->getAction("prefix") === "admin" && Str::endsWith($route->getAction("as"), "index")){
                return $route->getAction("as");
            }
        })->filter()->toArray();

        $routeValues = array_values($routes);
        $routes = array_combine($routeValues, $routeValues);

        $permissions = Permission::all()->pluck("name","name")->toArray();

        if(Cache::has("dashboard_menu")) Cache::forget("dashboard_menu");

        return view("admin.menu.index")
            ->with("title", trans("admin.menu.title"))
            ->with("newtitle", trans("admin.common.add"))
            ->with("buttons",$buttons)
            ->with("routes", $routes)
            ->with("permissions",$permissions)
            ->with("menu", Menu::nestable());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param MenuRequest $request
     * @return mixed
     */
    public function store(MenuRequest $request)
    {
        $model = new \App\Models\Menu();
        $model->fill($request->input());
        $model->save();

        if(Cache::has("dashboard_menu")) Cache::forget("dashboard_menu");

        $data = [
            "nestable" => Menu::nestableHtml(),
        ];

        return response()->success(["data" => $data]);
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
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(\App\Models\Menu $menu)
    {
        $buttons = [
            \Button::backButton(route("admin.menu.index"),["admin.menu.index"]),
            \Button::ajaxSubmitButton("form",["admin.menu.update"])
        ];

        $routes = collect(\Route::getRoutes())->map(function ($route) {
            if($route->getAction("prefix") === "admin" && Str::endsWith($route->getAction("as"), "index")){
                return $route->getAction("as");
            }
        })->filter()->toArray();

        $routeValues = array_values($routes);
        $routes = array_combine($routeValues, $routeValues);

        $permissions = Permission::all()->pluck("name","name")->toArray();

        return view("admin.menu.edit")
            ->with("model", $menu)
            ->with("title", trans("admin.menu.title"))
            ->with("edittitle", trans("admin.common.edit"))
            ->with("buttons",$buttons)
            ->with("routes", $routes)
            ->with("permissions",$permissions)
            ->with("menu", Menu::nestable());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, \App\Models\Menu $menu)
    {
        $menu->fill($request->input());
        $menu->save();

        return response()->redirectToJson(route("admin.menu.index"));
    }

    /**
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(\App\Models\Menu $menu)
    {
        \App\Models\Menu::query()->where("menu_id", $menu->id)->forceDelete();
        $menu->forceDelete();

        return redirect()->back();
    }

    public function selectedDestroy(Request $request)
    {
        dd($request->input());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable()
    {
        return (new MenuDatatable())->datatable();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function order(Request $request)
    {
        $orders = (new MenuDatatable())->order($request->input('orders'));
        if($orders) return response()->success();

        return response()->error();
    }

    public function updateNestable(Request $request)
    {
        for ($i = 0; $i < count($request->input()); $i++){
            if(isset($request->input()[$i]["id"])){
               $menu = \App\Models\Menu::find($request->input()[$i]["id"]);
               $menu->order = $i;
               $menu->menu_id = null;
               $menu->save();
            }
            if(isset($request->input()[$i]["children"])){
                $this->nestedChildren($request->input()[$i]["children"], $request->input()[$i]["id"]);
            }
        }

        if(Cache::has("dashboard_menu")) Cache::forget("dashboard_menu");
        return response()->success(null,["data" => Menu::renderHtml()]);
    }

    public function nestedChildren(array $data, $parent_id = null)
    {
        for ($i = 0; $i < count($data); $i++){
            if(isset($data[$i]["id"])){
                $menu = \App\Models\Menu::find($data[$i]["id"]);
                $menu->order = $i;
                $menu->menu_id = $parent_id;
                $menu->save();
            }

            if(isset($data[$i]["children"])){
                $this->nestedChildren($data[$i]["children"],$data[$i]["id"]);
            }
        }
    }
}
