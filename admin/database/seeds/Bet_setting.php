<?php

use Illuminate\Database\Seeder;
use App\Bet_set;

class Bet_setting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bet_set = [
            [
                'id'           => 1,
                'bet_type' => '1D',
                'payout' => '1:1',
                'max_amount' => 200,
                'difference' => 20,
            ], [
                'id'           => 2,
                'bet_type' => 'Big / Small',
                'payout' => '1:1',
                'max_amount' => 200,
                'difference' => 20,

            ], [
                'id'           => 3,
                'bet_type' => 'Even / Odd',
                'payout' => '1:1',
                'max_amount' => 200,
                'difference' => 20,
            ], [
                'id'           => 4,
                'bet_type' => '0 & 5',
                'payout' => '1:1',
                'max_amount' => 200,
                'difference' => 20,
            ]
        ];

        Bet_set::insert($bet_set);
    }
}
