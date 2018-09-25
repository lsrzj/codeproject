<?php

namespace CodeProject\Entities\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectMembers extends Model implements Transformable {
    use TransformableTrait;

    public $timestamps = FALSE;

    protected $fillable = [
        'user_id',
        'project_id'
    ];

    public function projects() {
        $this->belongsTo(Project::class);
    }

    public function member() {
        $this->belongsTo(User::class);
    }
}