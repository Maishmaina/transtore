<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',

            'view operators',
            'create operators',
            'edit operators',
            'delete operators',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'guard_name' => 'admin_api',
                'name' => $permission
            ]);
        }
    }
}
