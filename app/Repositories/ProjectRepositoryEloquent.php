<?php


namespace CodeProject\Repositories;


use CodeProject\Entities\Eloquent\Project;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository {


  public function model() {
    return Project::class;
  }

  public function isMember($id, $memberId) {
    $project = $this->findWhere(['project_id' => $id, 'owner_id' => $memberId);
    if ($project) {
      return true;
    }
    return false;
  }
}