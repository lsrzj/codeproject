<?php

namespace CodeProject\Entities\Doctrine;

use Carbon\Carbon;

class ProjectNote implements \JsonSerializable {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $note;

    /**
     * @var Carbon
     */
    private $created_at;

    /**
     * @var Carbon
     */
    private $updated_at;

    /**
     * @var \CodeProject\Entities\Doctrine\Project
     */
    private $project;

    public function __construct($title, $note, $project) {
        $this->title = $title;
        $this->note = $note;
        $this->project = $project;
    }

    public function __toString() {
        return json_encode([
            'id' => $this->id,
            'title' => $this->title,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ], JSON_UNESCAPED_UNICODE);
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
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
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getNote(): string {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote(string $note): void {
        $this->note = $note;
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

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon {
        return $this->created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon {
        return $this->updated_at;
    }
}