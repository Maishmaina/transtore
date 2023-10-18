<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Admin::find(1);
        $role = Role::where('name', 'Super Admin')->first();
        $permissions = Permission::all();

        $role->syncPermissions($permissions);
        $superAdmin->assignRole($role);
    }
}
