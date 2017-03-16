<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator{
    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'progress' => 'required',
        'status' => 'required',
        'due_date' => 'required'
    ];
}
