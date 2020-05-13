<?php

use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            'ranking_count' => 23,
            'date' => '2019-4-5',
            'time' => '10:20:32',
        ]);
    }
}
