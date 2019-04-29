<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()	{
		DB::table('users')->insert([
			'name' => 'Sander Buruma',
			'email' => 'sanderburuma@gmail.com',
			'password' => '$2y$10$jQY5ljXUPHkKlkREkFhC8eJh6FiDSgo/tGFspsC.1phnt.UgcQhp.', //see the default laravel password entry in Bitwarden
			'created_at' => '2018-12-03 09:49:03',
			'updated_at' => '2018-12-03 09:49:03',
			'email_verified_at' => '2018-12-03 09:50:33',
		]);
		
		DB::table('roles')->insert([
			'name' => 'Approved',
		]);
		DB::table('roles')->insert([
			'name' => 'Moderator',
		]);
		DB::table('roles')->insert([
			'name' => 'Admin',
		]);
		DB::table('roles')->insert([
			'name' => 'Banned',
		]);
		
		DB::table('role_user')->insert([
			'user_id' => '1',
			'role_id' => '1',
		]);
		DB::table('role_user')->insert([
			'user_id' => '1',
			'role_id' => '2',
		]);
		DB::table('role_user')->insert([
			'user_id' => '1',
			'role_id' => '3',
		]);
	}
}
