<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->call(RoleSeeder::class);
		$this->call(ServiceTypeSeeder::class);
		$this->call(OrderStatusSeeder::class);

		$this->call(StoreSeeder::class);
		$this->call(ShipperSeeder::class);
		$this->call(OrderSeeder::class);

		$this->call(AdminSeeder::class);
	}
}
