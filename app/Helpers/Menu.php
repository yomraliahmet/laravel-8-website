<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class Menu
{
    /**
     * @return array
     */
    public static function toArray()
    {
        $menus =  Cache::rememberForever('dashboard_menu', function () {
           return \App\Models\Menu::query()->with(["menus" => function($query){
                $query->with("childrenMenus")->withTranslation()->orderBy("order","asc");
            }])
                ->withTranslation()
                ->whereNull("menu_id")
                ->orderBy("order","asc")
                ->get()
                ->toArray();
        });

        return $menus;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public static function render()
    {
        $menus = self::toArray();

        return view(config("admin.view_path").".navigation.navigations", compact("menus"));
    }

    /**
     * @return string
     */
    public static function renderHtml()
    {
       $menus = self::toArray();
       $html = view(config("admin.view_path").".navigation.navigations", compact("menus"))->render();

       return $html;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public static function nestable()
    {
        $menus = self::toArray();

        return view(config("admin.view_path").".nestable.nestable", compact("menus"));
    }

    /**
     * @return string
     */
    public static function nestableHtml()
    {
        $menus = self::toArray();

        return view(config("admin.view_path").".nestable.nestable", compact("menus"))->render();
    }

}
