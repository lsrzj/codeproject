<?php

namespace CodeProject\Entities\Doctrine;

class Project implements \JsonSerializable {

    private $id;
    private $name;
    private $description;
    private $progress;
    private $status;
    private $due_date;
    private $created_at;
    private $updated_at;
    private $user;
    private $client;

    public function __construct($name, $description, $progress, $status, $due_date, $user, $client) {
        $this->name = $name;
        $this->description = $description;
        $this->progress = $progress;
        $this->status = $status;
        $this->due_date = $due_date;
        $this->user = $user;
        $this->client = $client;
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

    function getDescription() {
        return $this->description;
    }

    function getProgress() {
        return $this->progress;
    }

    function getStatus() {
        return $this->status;
    }

    function getDue_date() {
        return $this->due_date;
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

    function setDescription($description) {
        $this->description = $description;
    }

    function setProgress($progress) {
        $this->progress = $progress;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDue_date($due_date) {
        $this->due_date = $due_date;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdated_at($updated_at) {
        $this->updated_at = $updated_at;
    }

    function getUser() {
        return $this->user;
    }

    function getClient() {
        return $this->client;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setClient($client) {
        $this->client = $client;
    }

}
