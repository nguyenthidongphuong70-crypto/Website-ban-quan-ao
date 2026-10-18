<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Áo thun', 'Áo sơ mi', 'Áo khoác', 'Áo polo'] as $name) {
            if (!DB::table('categories')->where('name', $name)->exists()) {
                DB::table('categories')->insert(['name' => $name]);
            }
        }
    }
}
