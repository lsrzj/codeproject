<?php

namespace CodeProject\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProjectTask.
 *
 * @package namespace CodeProject\Entities;
 */
class ProjectTask extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'name'
        ,'project_id'
        ,'start_date'
        ,'due_date'
        ,'status'
    ];

}
