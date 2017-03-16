<?php

use Illuminate\Database\Seeder;
use CodeProject\Entities\Eloquent\User;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::Table('users')->delete();
        factory(User::class, 100)->create();
    }

}
