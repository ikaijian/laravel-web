<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Status::class, function (Faker $faker) {
    $data_time=$faker->date. ' '.$faker->time;
    return [
        //微博数据填充假数据工厂
        'content'=>$faker->text(),
        'created_at'=>$data_time,
        'updated_at'=>$data_time,
    ];
});
