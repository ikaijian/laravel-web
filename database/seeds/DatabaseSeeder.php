<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UsersTableSeeder::class);

        //指定调用微博数据填充文类
        $this->call(StatusesTableSeeder::class);

        //指定调用关注假数据填充类
        $this->call(FollowersTableSeeder::class);
        Model::reguard();
    }
}
