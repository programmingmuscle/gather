<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'title' => $faker->text($faker->numberBetween(10,191)),
        'date_time' => $faker->randomElement([date('Y'), date('Y')+1]) . '/' . $faker->month . '/' . $faker->dayOfMonth . ' ' . $faker->numberBetween(0, 23) . ':' . $faker->randomElement(['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59']) . '~' . $faker->numberBetween(0, 23) . ':' . $faker->randomElement(['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59']),
        'place' => $faker->locale,
        'address' => $faker->address,
        'reservation' => $faker->randomElement(['不要', '予約済み', '未予約']),
        'expense' => $faker->text($faker->numberBetween(10,191)),
        'ball' => $faker->randomElement(['軟式', '硬式']),
        'deadline' => $faker->year . '/' . $faker->month . '/' . $faker->dayOfMonth . ' ' . $faker->numberBetween(0, 23) . ':' . $faker->numberBetween(00, 59),
        'people' => $faker->randomElement(['1人', '2人', '3人', '4人', '5人', '6人', '7人', '8人', '9人', '10人', '11人', '12人', '13人', '14人', '15人', '16人', '17人', '18人', '19人', '20人', '21人', '22人', '23人', '24人', '25人', '26人', '27人', '28人', '29人', '30人', '31人', '32人', '33人', '34人', '35人', '36人', '37人', '38人', '39人', '40人']),
        'remarks' => $faker->text($faker->numberBetween(10,191)),
    ];
});
