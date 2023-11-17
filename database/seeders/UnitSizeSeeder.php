<?php

namespace Database\Seeders;

use App\Models\UnitSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $unit_size = [['name' => 'Small'], ['name' => 'Medium'], ['name' => 'Large']];
        foreach ($unit_size as $size) {
        UnitSize::create(['name'=>$size['name']]);
        }
    }
}
