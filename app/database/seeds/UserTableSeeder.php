<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		User::create(array(
			'username' 		=> 'root',
			'password' 		=> 'root5566',
			'title' 		=> 'Admin Ruoshi',
			'roles' 		=> 'administrator',
			'email' 		=> 'fntsrlike@gmail.com',
			'phone' 		=> '0937732363',
		));

		User::create(array(
			'username' 		=> 'manager',
			'password' 		=> 'manager5566',
			'title' 		=> 'Manager Yuehu',
			'roles' 		=> 'manager',
			'email' 		=> 'yuehu@gmail.com',
			'phone' 		=> '0937732362',
		));

		$faker = Faker\Factory::create();
		for ($i=0; $i < 30; $i++) {
			User::create(array(
				'username' 		=> $faker->userName,
				'password' 		=> $faker->password,
				'title' 		=> $faker->firstName($gender = null|'male'|'female'),
				'roles' 		=> $faker->randomElement($array = array ('normal','applicant')),
				'email' 		=> $faker->freeEmail,
				'phone' 		=> $faker->phoneNumber,
			));
		}
	}
}
