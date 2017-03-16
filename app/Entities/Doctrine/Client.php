<?php

namespace CodeProject\Entities\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;

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

    public function __construct() {
        $this->projects = new ArrayCollection();
    }

    public function __toString() {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'responsible' => $this->responsible,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'obs' => $this->obs,
            'created_at' => $this->created_at->__toString(),
            'updated_at' => $this->updated_at->__toString(),
            'projects' => $this->projects
        ]);
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'responsible' => $this->responsible,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'obs' => $this->obs,
            'created_at' => $this->created_at->__toString(),
            'updated_at' => $this->updated_at->__toString(),
            'projects' => $this->projects
        ];
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
