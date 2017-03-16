<?php

use Illuminate\Database\Seeder;
use CodeProject\Entities\Eloquent\Project;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('projects')->delete();
        factory(Project::class, 10)->create();
    }
}
