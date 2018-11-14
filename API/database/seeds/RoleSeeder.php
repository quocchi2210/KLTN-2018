<?php
/**
 * Created by PhpStorm.
 * User: BSS
 * Date: 11/14/2018
 * Time: 10:35 AM
 */
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        \App\Role::create([
            'name' => 'Owner Store',
            'description' => 'Owner Store',
        ]);
    }

}