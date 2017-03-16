<?php

namespace CodeProject\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = [
        'name',
        'description',
        'progress',
        'status',
        'due_date'
    ];
    
    public function client() {
        return $this->belongsTo('CodeProject\Entities\Eloquent\Client');
    }
    
    public function user() {
        return $this->belongsTo('CodeProject\Entities\Eloquent\User', 'owner_id');
    }
}
