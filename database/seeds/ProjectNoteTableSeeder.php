<?php

use Illuminate\Database\Seeder;
use CodeProject\Entities\Eloquent\ProjectNote;

class ProjectNoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectNote::truncate();
        factory(ProjectNote::class, 10)->create();
    }
}
