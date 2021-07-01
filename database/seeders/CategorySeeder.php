<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('categories')->insert([
            ['title' => 'General', 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Music', 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Movies', 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Politics', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
