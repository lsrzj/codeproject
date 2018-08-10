<?php

namespace CodeProject\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\App;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except; 
    
    public function __construct(\Illuminate\Foundation\Application $app, \Illuminate\Contracts\Encryption\Encrypter $encrypter) {
        parent::__construct($app, $encrypter);
        if  (App::environment('staging')) {
            $this->except = ['client'];    
        }
        else  if (App::environment('local')) {
            $this->except = [];         
        }
    }
}
