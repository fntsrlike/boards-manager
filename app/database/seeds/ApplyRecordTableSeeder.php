<?php

class ApplyRecordTableSeeder extends Seeder {

	const LARGE_POSTER_DAYS = 6;
	const INTERNAL_DAYS = 14;
	const EXTERNAL_DAYS = 21;
	const UNION_DAYS = 28;

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i=0; $i < 70; $i++) {
			$user = User::where('roles', 'applicant')->get()->shuffle()->first();
			$board = null;

			while ( null == $board ) {
				$day_type = array('internal' => self::INTERNAL_DAYS,
								  'external' => self::EXTERNAL_DAYS,
								  'union'    => self::UNION_DAYS);
				$type = $faker->randomElement(['internal', 'external', 'union']);
				$days = $day_type[$type] - 1;

				$from = date_format($faker->dateTimeBetween('-3 months', '+3 months'), 'Y-m-d');
				$end  = date('Y-m-d', strtotime("{$from} + {$days} days"));

				$board = Board::where('type', '!=', 'large')->isEmpty($from, $end)->get()->shuffle()->first();
			}

			ApplyRecord::create(array(
				'board_id'      => $board->id,
				'user_id'       => $user->id,
				'event_name'    => $faker->company(),
				'event_type'    => $type,
				'post_from'     => $from,
				'post_end'      => $end,
			));
		}

		for ($i=0; $i < 30; $i++) {
			$user = User::where('roles', 'applicant')->get()->shuffle()->first();
			$board = null;

			while ( null == $board ) {
				$type = $faker->randomElement(['internal', 'external', 'union']);
				$days = self::LARGE_POSTER_DAYS - 1;

				$from = date_format($faker->dateTimeBetween('-3 months', '+3 months'), 'Y-m-d');
				$end  = date('Y-m-d', strtotime("{$from} + {$days} days"));

				$board = Board::where('type', 'large')->isEmpty($from, $end)->get()->shuffle()->first();
			}

			ApplyRecord::create(array(
				'board_id'      => $board->id,
				'user_id'       => $user->id,
				'event_name'    => $faker->company(),
				'event_type'    => $type,
				'post_from'     => $from,
				'post_end'      => $end,
			));
		}

	}
}
