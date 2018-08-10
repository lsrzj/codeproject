<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 07/08/18
 * Time: 15:54
 */

namespace CodeProject\Validators;


class ClientValidator extends LaravelValidator {
    protected $rules = [
        'name' => 'required|max:255',
        'responsible' => 'required|max:255',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required'
    ];
}