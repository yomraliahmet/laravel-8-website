<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::create([
            'currency' => Setting::CURRENCIES_TRY,
        ]);

        $setting->image()->save(new Image([
            'image' => \Intervention::make(database_path("seeders/images/logo.png")),
            'key' => 'logo'
        ]));
    }
}
