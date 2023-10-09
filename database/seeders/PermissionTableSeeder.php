<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();

        $roles = Role::whereIn('name', ['Admin', 'SuperAdmin', 'User'])->get()->keyBy('name');

        ////////// dashboard ///////////
        $adminDashboard[] = Permission::firstOrCreate(['name' => 'view admin dashboard'], ['guard_name' => 'web']);

        ////////// users///////////
        $user[] = Permission::firstOrCreate(['name' => 'view user'], ['guard_name' => 'web']);
        $user[] = Permission::firstOrCreate(['name' => 'update user status'], ['guard_name' => 'web']);


        ////////////// facebook
        $facebook[] = Permission::firstOrCreate(['name' => 'view facebook posts'], ['guard_name' => 'web']);

        ////////////// admin ////////////////
        $admin[] = Permission::firstOrCreate(['name' => 'create admin'], ['guard_name' => 'web']);
        $admin[] = Permission::firstOrCreate(['name' => 'view admin'], ['guard_name' => 'web']);
        $admin[] = Permission::firstOrCreate(['name' => 'delete admin'], ['guard_name' => 'web']);
        $admin[] = Permission::firstOrCreate(['name' => 'update admin'], ['guard_name' => 'web']);


        ////////////// user dashboard ////////////////
        $userDashboard[] = Permission::firstOrCreate(['name' => 'view user dashboard'], ['guard_name' => 'web']);
        $userDashboard[] = Permission::firstOrCreate(['name' => 'view own posts'], ['guard_name' => 'web']);
        /////////////// sync ////////////////////
        $sync[] = Permission::firstOrCreate(['name' => 'sync facebook'], ['guard_name' => 'web']);
        $sync[] = Permission::firstOrCreate(['name' => 'sync twitter'], ['guard_name' => 'web']);
        $sync[] = Permission::firstOrCreate(['name' => 'sync instagram'], ['guard_name' => 'web']);

        $roles['User']->syncPermissions(array_merge($userDashboard));
        /**All To User */

        $roles['SuperAdmin']->syncPermissions(array_merge($adminDashboard, $admin, $sync, $facebook));
        /**All To superadmin */

        $roles['Admin']->syncPermissions(array_merge($adminDashboard, $sync, $facebook));
        /**All To superadmin */

        Schema::enableForeignKeyConstraints();
    }
}
