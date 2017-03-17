<?php

namespace CodeProject\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;
use CodeProject\Entities\Eloquent\Project;

class Client extends Model {

    protected $fillable = [
        'name',
        'responsible',
        'email',
        'phone',
        'address',
        'obs'
    ];

    public function projects() {
        return $this->hasMany(Project::class);
    }
}
