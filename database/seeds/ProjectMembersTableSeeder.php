<?php

use Illuminate\Database\Seeder;
use CodeProject\Entities\Eloquent\ProjectMembers;

class ProjectMembersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        ProjectMembers::truncate();
        factory(ProjectMembers::class, 10)->create();
    }
}
