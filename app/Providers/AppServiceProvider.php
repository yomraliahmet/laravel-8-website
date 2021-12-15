<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       View::share('templateUrl', url('assets/backend/templates/'. config('admin.template')));
       View::share('templateViewPath', config("admin.view_path"));

        if (!$this->app->runningInConsole()) {
            $config = [];

            $setting = Setting::query()->find(1);
            if($setting){
                $setting->with('image');
                $config["currency"] = $setting->currency;
                $config["logo"] = $setting->image->where("key","logo")
                    ->first()
                    ->only(['name','width','height']);
            }

            // Contact Info
            $contact = Contact::query()->find(1);
            if($contact){
                $contact->toArray();
                $config["contact"] = [
                    "phone" => $contact["phone"],
                    "email" => $contact["email"],
                    "address" => $contact["address"]
                ];
            }

            View::share('config',$config);
        }
    }
}
