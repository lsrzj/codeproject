<?php

use Illuminate\Database\Seeder;
use CodeProject\Entities\Eloquent\Client;

class ClientTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::Table('clients')->delete();
        factory(Client::class, 100)->create();
    }

}
