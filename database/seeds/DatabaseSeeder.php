<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            WinnumbersTableSeeder::class,
        ]);
        DB::table('configurations')->insert([
            'ranking_count' => 23,
            'date' => '2019-4-5',
            'time' => '10:20:32',
        ]);
    }
}
