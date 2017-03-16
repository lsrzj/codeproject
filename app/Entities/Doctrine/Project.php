<?php

namespace CodeProject\Entities\Doctrine;

class Project implements \JsonSerializable {

    /**
     *
     * @var integer
     */
    private $id;

    /**
     *
     * @var string 
     */
    private $name;

    /**
     *
     * @var string
     */
    private $description;

    /**
     *
     * @var float
     */
    private $progress;

    /**
     *
     * @var integer
     */
    private $status;

    /**
     *
     * @var Carbon\Carbon
     */
    private $due_date;

    /**
     *
     * @var Carbon\Carbon
     */
    private $created_at;

    /**
     *
     * @var Carbon\Carbon
     */
    private $updated_at;

    /**
     *
     * @var CodeProject\Entities\Doctrine\User
     */
    private $user;

    /**
     *
     * @var CodeProject\Entities\Doctrine\Client
     */
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
        return json_encode([
            'name' => $this->name,
            'description' => $this->description,
            'progress' => $this->progress,
            'status' => $this->status,
            'due_date' => $this->due_date->__toString(),
            'created_at' => $this->created_at->__toString(),
            'updated_at' => $this->updated_at->__toString(),
            'user' => $this->user,
            'client' => $this->client
        ]);
    }

    public function jsonSerialize() {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'progress' => $this->progress,
            'status' => $this->status,
            'due_date' => $this->due_date->__toString(),
            'created_at' => $this->created_at->__toString(),
            'updated_at' => $this->updated_at->__toString(),
            'user' => $this->user,
            'client' => $this->client            
        ];
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
