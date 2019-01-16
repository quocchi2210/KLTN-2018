<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('users')->insert([
			[
				'idUser' => null,
				'email' => 'shipper@gmail.com',
				'password' => "$2y$10$DuhQddyTlv5mlJaYAhrGPupq2cuhh1RboGb8BJ75/SArC5OXQ37sS",
				'roleId' => 2,
			],

			[
				'idUser' => null,
				'email' => 'store@gmail.com',
				'password' => "$2y$10$DuhQddyTlv5mlJaYAhrGPupq2cuhh1RboGb8BJ75/SArC5OXQ37sS",
				'roleId' => 1,
			],
		]);
	}
}
