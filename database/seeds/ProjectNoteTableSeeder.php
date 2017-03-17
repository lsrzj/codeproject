<?php

use Illuminate\Database\Seeder;
use CodeProject\Entities\Eloquent\ProjectNote;

class ProjectNoteTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::Table('project_notes')->delete();
        factory(ProjectNote::class, 100)->create();
    }

}
