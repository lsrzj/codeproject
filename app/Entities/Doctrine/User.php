<?php

namespace CodeProject\Entities\Doctrine;

use Illuminate\Auth\Authenticatable;
use LaravelDoctrine\ORM\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User implements AuthenticatableContract,
                      AuthorizableContract,
                      CanResetPasswordContract, 
                      \JsonSerializable  
{

    use Authenticatable,
        Authorizable,
        CanResetPassword;

    private $id;
    private $name;
    private $email;
    private $password;
    private $remember_token;
    private $created_at;
    private $updated_at;
    private $projects;

    public function __construct($name, $email, $password, $remember_token, $projects) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->remember_token = $remember_token;
        $this->projects = $projects;
    }
    
    public function __toString() {
        return json_encode(get_object_vars($this));
    }
    
    public function jsonSerialize() {
        return get_object_vars($this);
    }
    
    public function getAuthIdentifierName() {
        return 'id';
    }

    public function getKey() {
        return $this->id;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getRemember_token() {
        return $this->remember_token;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function getUpdated_at() {
        return $this->updated_at;
    }

    function getProjects() {
        return $this->projects;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setRemember_token($remember_token) {
        $this->remember_token = $remember_token;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdated_at($updated_at) {
        $this->updated_at = $updated_at;
    }

    function setProjects($projects) {
        $this->projects = $projects;
    }

}
