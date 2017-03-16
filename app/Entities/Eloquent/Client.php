<?php

namespace CodeProject\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany('CodeProject\Entities\Eloquent\Project');
    }
}
