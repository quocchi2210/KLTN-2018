<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'test1',
            'email' => 'test1@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }

}
