<?php

namespace CodeProject\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use CodeProject\Entities\Eloquent\Project;

class ProjectNote extends Model implements Transformable {

    use TransformableTrait;

    protected $fillable = [
        'poject_id',
        'title',
        'note'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

}
