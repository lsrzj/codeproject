<?php

namespace CodeProject\Entities\Doctrine;

class Client implements \JsonSerializable {

    private $id;
    private $name;
    private $responsible;
    private $email;
    private $phone;
    private $address;
    private $obs;
    private $created_at;
    private $updated_at;
    private $projects;

    public function __construct($name, $responsible, $email, $phone, $address, $obs) {
        $this->name = $name;
        $this->responsible = $responsible;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->obs = $obs;
    }

    public function __toString() {
        return json_encode(get_object_vars($this));
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getResponsible() {
        return $this->responsible;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone() {
        return $this->phone;
    }

    function getAddress() {
        return $this->address;
    }

    function getObs() {
        return $this->obs;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function getUpdated_at() {
        return $this->updated_at;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setResponsible($responsible) {
        $this->responsible = $responsible;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdated_at($updated_at) {
        $this->updated_at = $updated_at;
    }

    function getProjects() {
        return $this->projects;
    }

    function setProjects($projects) {
        $this->projects = $projects;
    }

}
