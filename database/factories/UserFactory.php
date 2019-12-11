<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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
$factory->define(\DG\Dissertation\Admin\Models\Organizer::class, function (Faker $faker) {
    $name = $faker->unique()->company;
    return [
        'name' => $name,
        'slug' => \Str::slug($name),
        'email' => $faker->unique()->email,
        'password' => bcrypt('password'), // password
        'phone' => $faker->unique()->phoneNumber,
        'address' => $faker->address,
        'description' => $faker->text(100),
        'website' => $faker->domainName,
    ];
});

$factory->define(\DG\Dissertation\Admin\Models\Event::class, function (Faker $faker) {
    $name = $faker->text(20);
    $rand = rand(1, 12);
    return [
        'name' => $name,
        'slug' => \Str::slug($name),
        'date' => now()->addMonths($rand),
        'address' => $faker->address,
        'thumbnail' => $faker->imageUrl(500, 300),
        'description' => $faker->text(200),
        'status' => array_rand([\DG\Dissertation\Admin\Supports\ConstantDefine::EVENT_STATUS_ACTIVE, \DG\Dissertation\Admin\Supports\ConstantDefine::EVENT_STATUS_PENDING], 1)
    ];
});

$factory->define(\DG\Dissertation\Admin\Models\Ticket::class, function (Faker $faker) {
    return [
        'name' => $faker->text(10),
        'cost' => $faker->numberBetween(0, 200),
    ];
});
$factory->define(\DG\Dissertation\Admin\Models\Channel::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
    ];
});
$factory->define(\DG\Dissertation\Admin\Models\Room::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'capacity' => $faker->numberBetween(100, 500),
    ];
});
$factory->define(\DG\Dissertation\Admin\Models\Speaker::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'photo' => $faker->imageUrl(100, 100),
        'company' => $faker->company,
        'position' => $faker->jobTitle,
        'description' => $faker->text(200),
    ];
});
$factory->define(\DG\Dissertation\Admin\Models\Partner::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'logo' => $faker->imageUrl(200, 150),
        'description' => $faker->text(200),
    ];
});
$factory->define(\DG\Dissertation\Api\Models\Attendee::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->email,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'photo' => $faker->imageUrl(200, 200),
        'password' => bcrypt('password'),
        'email_verified_at' => now()->toDateTimeString(),
    ];
});
$factory->define(\DG\Dissertation\Admin\Models\SessionType::class, function (Faker $faker) {
    $name = $faker->randomElement(['Talk', 'Workshop']);
    return [
        'name' => $name,
        'cost' => $name === 'Talk' ? 0 : $faker->numberBetween(1, 150),
    ];
});
$factory->define(\DG\Dissertation\Admin\Models\Article::class, function (Faker $faker) {
    $name = $faker->text(50);
    return [
        'title' => $name,
        'slug' => \Str::slug($name),
        'thumbnail' => $faker->imageUrl(500, 300),
        'description' => $faker->text(100),
        'body' => $faker->paragraph,
        'status' => \DG\Dissertation\Admin\Supports\ConstantDefine::ARTICLE_STATUS_PUBLISH,
    ];
});
