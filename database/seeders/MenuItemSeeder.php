<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MenuItemSeeder extends Seeder
{
    public function run()
    {
        // Ambil Menu Group
        $menu = DB::table('menus')->where('title', 'Menu')->first();
        $others = DB::table('menus')->where('title', 'Others')->first();

        // =======================
        // GROUP 1: MENU
        // =======================

        // Dashboard
        $dashboardId = DB::table('menu_items')->insertGetId([
            'menu_id' => $menu->id,
            'name' => 'Dashboard',
            'icon' => 'dashboard',
            'order' => 1,
            'parent_id' => null,
            'path' => null,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('menu_items')->insert([
            [
                'menu_id' => $menu->id,
                'parent_id' => $dashboardId,
                'name' => 'Ecommerce',
                'icon' => 'ecommerce',
                'path' => '/',
                'order' => 1,
                'is_pro' => false,
                'icon' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'menu_id' => $menu->id,
            //     'parent_id' => $dashboardId,
            //     'name' => 'test',
            //     'path' => '/est',
            //     'order' => 2,
            //     'is_pro' => false,
            //     'icon' => null,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
        $organisasiid = DB::table('menu_items')->insertGetId([
            'menu_id' => $menu->id,
            'name' => 'Organization',
            'icon' => 'dashboard',
            'order' => 2,
            'parent_id' => null,
            'path' => null,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('menu_items')->insert([
            [
                'menu_id' => $menu->id,
                'parent_id' => $organisasiid,
                'name' => 'comunity it',
                'path' => '/community/Komunitas IT',
                'order' => 1,
                'is_pro' => false,
                'icon' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => $menu->id,
                'parent_id' => $organisasiid,
                'name' => 'comunity game',
                'path' => '/community/Komunitas Game',
                'order' => 2,
                'is_pro' => false,
                'icon' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Keuangan
        DB::table('menu_items')->insert([
            'menu_id' => $menu->id,
            'name' => 'Keuangan',
            'icon' => 'tables',
            'path' => '/keuangan',
            'parent_id' => null,
            'order' => 3,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Inventaris
        DB::table('menu_items')->insert([
            'menu_id' => $menu->id,
            'name' => 'Inventaris',
            'icon' => 'pages',
            'path' => '/inventaris',
            'parent_id' => null,
            'order' => 4,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Surat
        DB::table('menu_items')->insert([
            'menu_id' => $menu->id,
            'name' => 'Surat',
            'icon' => 'email',
            'path' => '/surat',
            'parent_id' => null,
            'order' => 5,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Calendar
        DB::table('menu_items')->insert([
            'menu_id' => $menu->id,
            'name' => 'Calendar',
            'icon' => 'calendar',
            'path' => '/calendar',
            'parent_id' => null,
            'order' => 6,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User Profile
        DB::table('menu_items')->insert([
            'menu_id' => $menu->id,
            'name' => 'User Profile',
            'icon' => 'user-profile',
            'path' => '/profile',
            'parent_id' => null,
            'order' => 7,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Forms
        $formsId = DB::table('menu_items')->insertGetId([
            'menu_id' => $menu->id,
            'name' => 'Forms',
            'icon' => 'forms',
            'path' => null,
            'order' => 8,
            'parent_id' => null,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('menu_items')->insert([
            'menu_id' => $menu->id,
            'parent_id' => $formsId,
            'name' => 'Form Elements',
            'path' => '/form-elements',
            'order' => 1,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // =======================
        // GROUP 2: OTHERS
        // =======================

        $chartsId = DB::table('menu_items')->insertGetId([
            'menu_id' => $others->id,
            'name' => 'Charts',
            'icon' => 'charts',
            'parent_id' => null,
            'order' => 1,
            'is_pro' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('menu_items')->insert([
            [
                'menu_id' => $others->id,
                'parent_id' => $chartsId,
                'name' => 'Line Chart',
                'path' => '/line-chart',
                'order' => 1,
                'is_pro' => false,
            ],
            [
                'menu_id' => $others->id,
                'parent_id' => $chartsId,
                'name' => 'Bar Chart',
                'path' => '/bar-chart',
                'order' => 2,
                'is_pro' => false,
            ],
        ]);
        DB::table('menu_items')->insert([
            'menu_id' => $others->id,
            'name' => 'Menu',
            'icon' => 'dashboard',
            'path' => '/menu-items',
            'parent_id' => null,
            'order' => 2,
            'is_pro' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }

}
