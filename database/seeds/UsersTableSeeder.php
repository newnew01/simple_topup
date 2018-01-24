<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'newnew01',
            'email' => 'aaa@aaa.com',
            'password' => Hash::make('1111'),
            'branch_name' => 'BANTA',
            'api_token' => str_random(60)
        ]);

    }
}
