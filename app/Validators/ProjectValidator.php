<?php
namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator{
    protected $rules = [
        'owner_id' => 'required|integer',
        'client_id' => 'required|integer',
        'name' => 'required|max:60',
        'description' => 'required',
        'progress' => 'required|numeric',
        'status' => 'required|numeric',
        'due_date' => 'required|date_format:Y-m-d'
    ];
}