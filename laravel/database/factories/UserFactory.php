<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
		'remember_token' => str_random(10),
		'residence' => $faker->address,
		'gender' => $faker->randomElement(['男性', '女性']),
		'age' => $faker->randomElement(['10代', '20代', '30代', '40代', '50代', '60代以上']),
		'experience' => $faker->randomElement(['5年未満', '5~10年', '10年以上']),
		'position' => $faker->randomElement(['投手', '捕手', '一塁手', '二塁手', '三塁手', '遊撃手', '左翼手', '中堅手', '右翼手', '内野全般', '外野全般']),
		'introduction' => $faker->text($faker->numberBetween(10,191)),
		'profile_image' => $faker->randomElement(['', 'profile_image']),
	];
});