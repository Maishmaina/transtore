<?php

namespace Database\Seeders;

use App\Models\StorageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StorageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indoorSubtypes = [
            'Personal Items',
            'Furniture',
            'Business Inventory',
            'Climate Control/Specialized',
        ];

        $outdoorSubtypes = [
            'Open',
            'Silo',
            'Vehicle',
            'Farm Equipment',
            'Container',
        ];

        $indoorStorage = StorageType::create([
            'name' => 'Indoor'
        ]);

        foreach ($indoorSubtypes as $indoorSubtype) {
            $indoorStorage->subtypes()->create([
                'name' => $indoorSubtype
            ]);
        }

        $outdoorStorage = StorageType::create([
            'name' => 'Outdoor'
        ]);

        foreach ($outdoorSubtypes as $outdoorSubtype) {
            $outdoorStorage->subtypes()->create([
                'name' => $outdoorSubtype
            ]);
        }
    }
}
