<?php

namespace CodeProject\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;
use CodeProject\Entities\Eloquent\Client;
use CodeProject\Entities\Eloquent\User;
use CodeProject\Entities\Eloquent\ProjectNote;

class Project extends Model
{

    protected $fillable = [
        'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
        'status',
        'due_date'
    ];
    
    public function client() {
        return $this->belongsTo(Client::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'owner_id');
    }
    
    public function notes() {
        return $this->hasMany(ProjectNote::class);
    }
}
