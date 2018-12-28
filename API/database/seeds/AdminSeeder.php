<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'fullName' => encrypt('admin'),
            'email' => encrypt('admin@admin.com'),
            'password' => bcrypt('123456'),
            'isActivated' => 1,
            'roleId' => 3
        ]);
    }
}
