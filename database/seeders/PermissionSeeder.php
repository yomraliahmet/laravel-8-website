<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create(["guard_name" => "admin", "name" => "admin"]);

        /*
         * Menu Permissions
         */
        $permissionGroup = PermissionGroup::create([
            "tr" => ["name" => "Menü"],
            "en" => ["name" => "Menu"],
        ]);

       $permissionGroup->permissions()->createMany([
            ["guard_name" => "admin", "name" => "admin.menu.index"],
            ["guard_name" => "admin", "name" => "admin.menu.create"],
            ["guard_name" => "admin", "name" => "admin.menu.store"],
            ["guard_name" => "admin", "name" => "admin.menu.edit"],
            ["guard_name" => "admin", "name" => "admin.menu.update"],
            ["guard_name" => "admin", "name" => "admin.menu.show"],
            ["guard_name" => "admin", "name" => "admin.menu.destroy"],
            ["guard_name" => "admin", "name" => "admin.menu.nestable"],
            ["guard_name" => "admin", "name" => "admin.menu.datatable"],
            ["guard_name" => "admin", "name" => "admin.menu.datatable.order"],
            ["guard_name" => "admin", "name" => "admin.menu.selected.destroy"],
        ]);

        /*
         * Translations Permissions
         */
        $permissionGroup = PermissionGroup::create([
            "tr" => ["name" => "Çeviriler"],
            "en" => ["name" => "Translations"],
        ]);

        $permissionGroup->permissions()->createMany([
            ["guard_name" => "admin", "name" => "languages.index"],
            ["guard_name" => "admin", "name" => "languages.create"],
            ["guard_name" => "admin", "name" => "languages.store"],

            ["guard_name" => "admin", "name" => "languages.translations.index"],
            ["guard_name" => "admin", "name" => "languages.translations.create"],
            ["guard_name" => "admin", "name" => "languages.translations.store"],
            ["guard_name" => "admin", "name" => "languages.translations.update"],

        ]);

        /*
         * Admin Permissions
         */
        $permissionGroup = PermissionGroup::create([
            "tr" => ["name" => "Yöneticiler"],
            "en" => ["name" => "Admins"],
        ]);

        $permissionGroup->permissions()->createMany([
            ["guard_name" => "admin", "name" => "admin.admin.index"],
            ["guard_name" => "admin", "name" => "admin.admin.create"],
            ["guard_name" => "admin", "name" => "admin.admin.store"],
            ["guard_name" => "admin", "name" => "admin.admin.edit"],
            ["guard_name" => "admin", "name" => "admin.admin.update"],
            ["guard_name" => "admin", "name" => "admin.admin.show"],
            ["guard_name" => "admin", "name" => "admin.admin.destroy"],

            ["guard_name" => "admin", "name" => "admin.admin.datatable"],
            ["guard_name" => "admin", "name" => "admin.admin.datatable.order"],
            ["guard_name" => "admin", "name" => "admin.admin.selected.destroy"],

        ]);

        /*
         * Permission Group Permissions
         */
        $permissionGroup = PermissionGroup::create([
            "tr" => ["name" => "Yetki Grupları"],
            "en" => ["name" => "Permission Groups"],
        ]);

        $permissionGroup->permissions()->createMany([
            ["guard_name" => "admin", "name" => "admin.permission-group.index"],
            ["guard_name" => "admin", "name" => "admin.permission-group.create"],
            ["guard_name" => "admin", "name" => "admin.permission-group.store"],
            ["guard_name" => "admin", "name" => "admin.permission-group.edit"],
            ["guard_name" => "admin", "name" => "admin.permission-group.update"],
            ["guard_name" => "admin", "name" => "admin.permission-group.show"],
            ["guard_name" => "admin", "name" => "admin.permission-group.destroy"],

            ["guard_name" => "admin", "name" => "admin.permission-group.datatable"],
            ["guard_name" => "admin", "name" => "admin.permission-group.datatable.order"],
            ["guard_name" => "admin", "name" => "admin.permission-group.selected.destroy"],
        ]);

        /*
         * Roles Permissions
         */
        $permissionGroup = PermissionGroup::create([
            "tr" => ["name" => "Roller"],
            "en" => ["name" => "Roles"],
        ]);

        $permissionGroup->permissions()->createMany([
            ["guard_name" => "admin", "name" => "admin.role.index"],
            ["guard_name" => "admin", "name" => "admin.role.create"],
            ["guard_name" => "admin", "name" => "admin.role.store"],
            ["guard_name" => "admin", "name" => "admin.role.edit"],
            ["guard_name" => "admin", "name" => "admin.role.update"],
            ["guard_name" => "admin", "name" => "admin.role.show"],
            ["guard_name" => "admin", "name" => "admin.role.destroy"],
            ["guard_name" => "admin", "name" => "admin.role.permission"],

            ["guard_name" => "admin", "name" => "admin.role.datatable"],
            ["guard_name" => "admin", "name" => "admin.role.datatable.order"],
            ["guard_name" => "admin", "name" => "admin.role.selected.destroy"],
        ]);

         /*
          * Contact Permissions
          */
        $permissionGroup = PermissionGroup::create([
            "tr" => ["name" => "İletişim Bilgileri"],
            "en" => ["name" => "Contact Information"],
        ]);

        $permissionGroup->permissions()->createMany([
            ["guard_name" => "admin", "name" => "admin.contact.edit"],
            ["guard_name" => "admin", "name" => "admin.contact.update"],
        ]);

        /*
         * Setting Permissions
         */
        $permissionGroup = PermissionGroup::create([
            "tr" => ["name" => "Ayarlar"],
            "en" => ["name" => "Settings"],
        ]);

        $permissionGroup->permissions()->createMany([
            ["guard_name" => "admin", "name" => "admin.setting.edit"],
            ["guard_name" => "admin", "name" => "admin.setting.update"],
        ]);

       $role->syncPermissions(Permission::all());

    }
}
