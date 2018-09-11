<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        Schema::disableForeignKeyConstraints();
        Model::unguard();
        $this->call(UserTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(ProjectNoteTableSeeder::class);
        //$this->call(ProjectTaskTableSeeder::class);
        Model::reguard();
        Schema::enableForeignKeyConstraints();
    }
}
