<?php

namespace CodeProject\Entities\Doctrine;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use DateTime;

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
     * @var DateTime
     */
    private $due_date;

    /**
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
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

    /**
     * @var PersistentCollection
     */
    private $projectNotes;

    /**
     * @var PersistentCollection
     */
    private $projectTasks;

    public function __construct($name, $description, $progress, $status, DateTime $due_date, User $user, Client $client) {
        $this->name = $name;
        $this->description = $description;
        $this->progress = $progress;
        $this->status = $status;
        $this->due_date = $due_date;
        $this->user = $user;
        $this->client = $client;
        $this->due_date = $due_date;
        $this->projectNotes = new ArrayCollection();
        $this->projectTasks = new ArrayCollection();
    }

    public function __toString() {
        return json_encode([
            'name' => $this->name,
            'description' => $this->description,
            'progress' => $this->progress,
            'status' => $this->status,
            'due_date' => $this->due_date->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
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
            'due_date' => $this->due_date->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user' => $this->user,
            'client' => $this->client
        ];
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getProgress(): float {
        return $this->progress;
    }

    /**
     * @param float $progress
     */
    public function setProgress(float $progress): void {
        $this->progress = $progress;
    }

    /**
     * @return int
     */
    public function getStatus(): int {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void {
        $this->status = $status;
    }

    public function getDueDate() {
        return $this->due_date;
    }

    public function setDueDate($due_date) {
        $this->due_date = $due_date;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime {
        return $this->created_at;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime {
        return $this->updated_at;
    }

    /**
     * @return CodeProject\Entities\Doctrine\User
     */
    public function getUser(): User {
        return $this->user;
    }

    /**
     * @param CodeProject\Entities\Doctrine\User $user
     */
    public function setUser(User $user): void {
        $this->user = $user;
    }

    /**
     * @return CodeProject\Entities\Doctrine\Client
     */
    public function getClient(): Client {
        return $this->client;
    }

    /**
     * @param CodeProject\Entities\Doctrine\Client $client
     */
    public function setClient(Client $client): void {
        $this->client = $client;
    }

    /**
     * @return ArrayCollection
     */
    public function getProjectNotes(): PersistentCollection {
        return $this->projectNotes;
    }

    /**
     * @param ArrayCollection $projectNotes
     */
    public function setProjectNotes(PersistentCollection $projectNotes): void {
        $this->projectNotes = $projectNotes;
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks(): PersistentCollection {
        return $this->projectTasks;
    }

    /**
     * @param ArrayCollection $projectTasks
     */
    public function setTasks(PersistentCollection $projectTasks): void {
        $this->projectTasks = $projectTasks;
    }
}