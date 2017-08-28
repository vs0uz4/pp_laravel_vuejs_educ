<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\SiGeEdu\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName . ' ' . $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'enrolment' => $faker->unique()->randomNumber(5),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\SiGeEdu\Models\UserProfile::class, function (Faker\Generator $faker) {
    return [
        'address' => $faker->address,
        'postal_code' => function() use($faker){
            $postalcode = preg_replace('/[^0-9]/','',$faker->postcode());
            return $postalcode;
        },
        'number' => rand(1,100),
        'complement' => rand(1,10)%2==0?null:$faker->sentence,
        'city' => $faker->city,
        'neighborhood' => $faker->city,
        'state' => collect(\SiGeEdu\Models\State::$states)->random(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\SiGeEdu\Models\Subject::class, function (Faker\Generator $faker) {
   return [
       'name' => $faker->word,
   ];
});

$factory->define(\SiGeEdu\Models\ClassInformation::class, function (Faker\Generator $faker){
    return [
        'date_start' => $faker->date(),
        'date_end' => $faker->date(),
        'cycle' => rand(1,8),
        'subdivision' => rand(1,16),
        'semester' => rand(1,2),
        'year' => rand(2017, 2030),
    ];
});