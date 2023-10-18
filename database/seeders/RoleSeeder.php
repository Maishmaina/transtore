<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin'
        ];

        foreach ($roles as $role) {
            Role::create([
                'guard_name' => 'admin_api',
                'name' => $role
            ]);
        }
    }
}
