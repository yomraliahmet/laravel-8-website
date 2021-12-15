<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ButtonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        class_alias("Html", "Button");
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Collective\Html\HtmlFacade::macro("backButton", function(string $url, array $permission = [], array $options = []){
          $properties = [
                "route" => $url,
                "name" => trans("admin.common.back"),
                "permission" => $permission,
                "icon" => $options["icon"] ?? "fas fa-arrow-alt-circle-left",
                "class" => $options["class"] ?? "btn bg-danger btn-tool text-white",
            ];
          foreach ($options as $key => $value){
              if(!array_key_exists($key,$properties))  $properties[$key] = $value;
          }
          return $properties;
        });

        \Collective\Html\HtmlFacade::macro("submitButton", function(string $url, array $permission, array $options = []){
            $properties = [
                "route" => $url,
                "name" => trans("admin.common.save"),
                "permission" => $permission,
                "icon" => $options["icon"] ?? "fas fa-save",
                "class" => $options["class"] ?? "btn bg-success btn-tool text-white",
            ];
            foreach ($options as $key => $value){
                if(!array_key_exists($key,$properties))  $properties[$key] = $value;
            }
            return $properties;
        });

        \Collective\Html\HtmlFacade::macro("ajaxSubmitButton", function(string $form, array $permission, array $options = []){
            $properties = [
                "name" => trans("admin.common.save"),
                "permission" => $permission,
                "icon" => $options["icon"] ?? "fas fa-save",
                "class" => $options["class"] ?? "btn bg-success btn-tool text-white",
                "form" => $form
            ];
            foreach ($options as $key => $value){
                if(!array_key_exists($key,$properties))  $properties[$key] = $value;
            }
            return $properties;
        });
    }
}
