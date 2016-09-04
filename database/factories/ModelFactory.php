<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\EmailLogin::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->safeEmail,
    ];
});

$factory->define(App\Survey::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomDigit,
        'title' => $faker->title,
        'description' => $faker->title,
        'status' => $faker->boolean,
    ];
});

$factory->define(App\SurveyResponses::class, function (Faker\Generator $faker) {
    return [
        'survey_id' => $faker->randomDigit,
        'email' => $faker->safeEmail,
        'status' => $faker->boolean,
    ];
});
