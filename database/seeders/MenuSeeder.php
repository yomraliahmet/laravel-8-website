<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::query()->create([
            "icon" => "fas fa-cog",
            "permission" => "admin.settings.index",
            "order" => 1,
            "is_active" => true,
            "tr" => ["name" => "Genel Ayarlar"],
            "en" => ["name" => "General Settings"],
        ]);

        Menu::query()->create([
            "menu_id" => 1,
            "route" => "admin.menu.index",
            "icon" => "far fa-arrow-alt-circle-right",
            "permission" => "admin.menu.index",
            "order" => 1,
            "is_active" => true,
            "tr" => ["name" => "Admin Menü"],
            "en" => ["name" => "Admin Menu"],
        ]);

        Menu::query()->create([
            "menu_id" => 1,
            "route" => "languages.index",
            "icon" => "far fa-arrow-alt-circle-right",
            "permission" => "languages.index",
            "order" => 1,
            "is_active" => true,
            "tr" => ["name" => "Çeviriler"],
            "en" => ["name" => "Translations"],
        ]);

        Menu::query()->create([
            "menu_id" => 1,
            "route" => "admin.admin.index",
            "icon" => "far fa-arrow-alt-circle-right",
            "permission" => "admin.admin.index",
            "order" => 1,
            "is_active" => true,
            "tr" => ["name" => "Yöneticiler"],
            "en" => ["name" => "Admins"],
        ]);

        Menu::query()->create([
            "menu_id" => 1,
            "route" => "admin.role.index",
            "icon" => "far fa-arrow-alt-circle-right",
            "permission" => "admin.role.index",
            "order" => 1,
            "is_active" => true,
            "tr" => ["name" => "Roller"],
            "en" => ["name" => "Roles"],
        ]);

        Menu::query()->create([
            "menu_id" => 1,
            "route" => "admin.permission-group.index",
            "icon" => "far fa-arrow-alt-circle-right",
            "permission" => "admin.permission-group.index",
            "order" => 1,
            "is_active" => true,
            "tr" => ["name" => "Yetki Grupları"],
            "en" => ["name" => "Permission Groups"],
        ]);

        Menu::query()->create([
            "menu_id" => 1,
            "route" => "admin.contact.edit",
            "icon" => "far fa-arrow-alt-circle-right",
            "permission" => "admin.contact.edit",
            "order" => 1,
            "is_active" => true,
            "tr" => ["name" => "İletişim Bilgileri"],
            "en" => ["name" => "Contact Information"],
        ]);

        Menu::query()->create([
            "menu_id" => 1,
            "route" => "admin.setting.edit",
            "icon" => "far fa-arrow-alt-circle-right",
            "permission" => "admin.setting.edit",
            "order" => 1,
            "is_active" => true,
            "tr" => ["name" => "Ayarlar"],
            "en" => ["name" => "Settings"],
        ]);
    }
}
