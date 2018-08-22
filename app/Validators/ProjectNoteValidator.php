<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 22/08/18
 * Time: 17:11
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator{
    protected $rules = [
        'project_id' => 'required|integer',
        'title' => 'required',
        'note' => 'required',
    ];
}