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
            'view customer details',
            'create customers',
            'edit customers',
            'delete customers',

            'view operators',
            'view operator details',
            'create operators',
            'edit operators',
            'delete operators',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            'view facilities',
            'create facilities',
            'edit facilities',
            'delete facilities',

            'view facility owners',
            'create facility owners',
            'edit facility owners',
            'delete facility owners',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'guard_name' => 'admin_api',
                'name' => $permission
            ]);
        }
    }
}
