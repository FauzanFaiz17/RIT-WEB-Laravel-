<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;


class MenuSeeder extends Seeder
{
    public function run()
    {
        DB::table('menus')->insert([
            ['title' => 'Menu', 'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Others', 'order' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

}
