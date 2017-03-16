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

        factory('CodeProject\Entities\Eloquent\User')->create(
            [
                'name' => 'admin',
                'email' => 'admin@larablog.com',
                'password' => bcrypt('123456'),
                'remember_token' => str_random(10),
            ]
        );
        
        $user = CodeProject\Entities\Eloquent\User::find(1);
        Auth::login($user);

        $this->call(ClientTableSeeder::class);
        $this->call(ProjectTableSeeder::class);

        Model::reguard();
    }
}
