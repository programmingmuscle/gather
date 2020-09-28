<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
	return [
		'user_id' => function() {
			return factory(App\User::class)->create()->id;
		},
		'title' => $faker->text($faker->numberBetween(10,191)),
		'date_time' => '2020-01-02 00:00:00',
		'end_time' => '2020-01-02 00:30:00',
		'place' => $faker->locale,
		'address' => $faker->address,
		'reservation' => $faker->randomElement(['不要', '予約済み', '未予約']),
		'expense' => $faker->text($faker->numberBetween(10,191)),
		'ball' => $faker->randomElement(['軟式', '硬式']),
		'deadline' => '2020-01-01 00:00:00',
		'people' => $faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40']),
		'remarks' => $faker->text($faker->numberBetween(10,191)),
	];
});