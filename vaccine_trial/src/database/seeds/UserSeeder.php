<?php

use Illuminate\Database\Seeder;
use App\Threshold;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Threshold::truncate();
        Threshold::insert([
            'threshhold' => 10
        ]);
    }
}
