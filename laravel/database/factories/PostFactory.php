<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'title' => $faker->text($faker->numberBetween(10,191)),
        'date_time' => $faker->randomElement([date('Y'), date('Y')+1]) . '-' . $faker->month . '-' . $faker->dayOfMonth . ' ' . $faker->time,
        'end_time' => $faker->time,
        'place' => $faker->locale,
        'address' => $faker->address,
        'reservation' => $faker->randomElement(['不要', '予約済み', '未予約']),
        'expense' => $faker->text($faker->numberBetween(10,191)),
        'ball' => $faker->randomElement(['軟式', '硬式']),
        'deadline' => $faker->randomElement([date('Y'), date('Y')+1]) . '-' . $faker->month . '-' . $faker->dayOfMonth . ' ' . $faker->time,
        'people' => $faker->randomElement(['1人', '2人', '3人', '4人', '5人', '6人', '7人', '8人', '9人', '10人', '11人', '12人', '13人', '14人', '15人', '16人', '17人', '18人', '19人', '20人', '21人', '22人', '23人', '24人', '25人', '26人', '27人', '28人', '29人', '30人', '31人', '32人', '33人', '34人', '35人', '36人', '37人', '38人', '39人', '40人']),
        'remarks' => $faker->text($faker->numberBetween(10,191)),
    ];
});
