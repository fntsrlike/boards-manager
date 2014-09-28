<?php

class BoardTableSeeder extends Seeder {

	public function run()
	{
		$normal = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'L', 'L'];
		$large  = ['W', 'X', 'Y', 'Z'];
		$stair  = ['S'];

		foreach ($normal as $code) {
			Board::create(array(
				'type' => 'normal',
				'code' => $code,
				'description' => "一般佈告欄{$code}",
			));
		}

		foreach ($large as $code) {
			Board::create(array(
				'type' => 'large',
				'code' => $code,
				'description' => "大掛報{$code}",
			));
		}

		foreach ($stair as $code) {
			Board::create(array(
				'type' => 'stair',
				'code' => $code,
				'description' => "樓梯佈告欄{$code}",
			));
		}
	}
}