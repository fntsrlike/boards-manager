<?php

return array(
	'board_types' => [
		'normal',
		'stairs',
		'large',
	],
	'event_types' => [
		'internal',
		'external',
		'internclub',
	],
	'days' => [
		'large_poster' => 3,
		'internal' => 14,
		'external' => 21,
		'internclub' => 28,
	],
	'name_mapping' => [
		'event_types' => [
			'internal' => 'Internal',
			'external' => 'External',
			'union' => 'Union/Interclub',
		],
	],

	// User can apply how many same type boards in meanwhile.
	'meanwhile_quota' => [
		'normal'	=> 1,
		'stairs'	=> 1,
		'large'		=> 1,
	],

	'cold_down' => 14, // Unit: days
);
