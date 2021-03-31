<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::truncate();

        Role::insert([
         [
             'role' => 'Volunteer'
            
         ],
         [
             'role' => 'Regulator'
         ],
         [
             'role' => 'Vaccine Maker'
         ]
        ]);
        
    }
}
