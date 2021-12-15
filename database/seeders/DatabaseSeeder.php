<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $files = glob(public_path("images").'/*');
        foreach($files as $file){
            if(is_file($file))
                unlink($file);
        }

         User::factory(5)->create();

         $this->call(PermissionSeeder::class);
         $this->call(AdminSeeder::class);
         $this->call(MenuSeeder::class);
         $this->call(ContactSeeder::class);
         $this->call(SettingSeeder::class);
         Artisan::call("cache:clear");
    }
}
