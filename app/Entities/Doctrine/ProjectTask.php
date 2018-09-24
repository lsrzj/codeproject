<?php

namespace CodeProject\Entities\Doctrine;

use DateTime;

class ProjectTask implements \JsonSerializable {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var DateTime
     */
    private $start_date;

    /**
     * @var DateTime
     */
    private $due_date;

    /**
     * @var int
     */
    private $status;

    /**
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
     */
    private $updated_at;

    /**
     * @var CodeProject\Entities\Doctrine\Project
     */
    private $project;

    public function __construct($name, DateTime $start_date, DateTime $due_date, $status, Project $project) {
        $this->name = $name;
        $this->start_date = $start_date;
        $this->due_date = $due_date;
        $this->status = $status;
        $this->project = $project;
    }

    public function __toString() {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date->format('Y-m-d H:i:s'),
            'due_date' => $this->due_date->format('Y-m-d H:i:s'),
            'status' => $this->status
        ], JSON_UNESCAPED_UNICODE);
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date->format('Y-m-d H:i:s'),
            'due_date' => $this->due_date->format('Y-m-d H:i:s'),
            'status' => $this->status
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
     * @return DateTime
     */
    public function getStartDate(): DateTime {
        return $this->start_date;
    }

    /**
     * @param DateTime $start_date
     */
    public function setStartDate(DateTime $start_date): void {
        $this->start_date = $start_date;
    }

    /**
     * @return DateTime
     */
    public function getDueDate(): DateTime {
        return $this->due_date;
    }

    /**
     * @param DateTime $due_date
     */
    public function setDueDate(DateTime $due_date): void {
        $this->due_date = $due_date;
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
     * @return Project
     */
    public function getProject(): Project {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project): void {
        $this->project = $project;
    }


}