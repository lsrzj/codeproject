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
   * @var CodeProject\Entities\Doctrine\Client
   */
  private $client;

  /**
   * @var PersistentCollection
   */
  private $notes;

  /**
   * @var PersistentCollection
   */
  private $tasks;

  /**
   * @var PersistentCollection
   */
  private $members;

  /**
   * @var User
   */
  private $owner;

  public function __construct($name, $description, $progress, $status, DateTime $due_date, User $owner, Client $client) {
    $this->name = $name;
    $this->description = $description;
    $this->progress = $progress;
    $this->status = $status;
    $this->due_date = $due_date;
    $this->owner = $owner;
    $this->client = $client;
    $this->due_date = $due_date;
    $this->notes = new ArrayCollection();
    $this->tasks = new ArrayCollection();
    $this->members = new ArrayCollection();
  }

  public function __toString() {
    return json_encode([
      'id' =>$this->id,
      'name' => $this->name,
      'description' => $this->description,
      'progress' => $this->progress,
      'status' => $this->status,
      'due_date' => $this->due_date->format('Y-m-d H:i:s'),
      'owner' => $this->owner,
      'client' => $this->client,
      'members' => $this->members->toArray()
    ]);
  }

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'progress' => $this->progress,
      'status' => $this->status,
      'due_date' => $this->due_date->format('Y-m-d H:i:s'),
      'owner' => $this->owner,
      'client' => $this->client,
      'members' => $this->members->toArray(),
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
  public function getNotes(): PersistentCollection {
    return $this->notes;
  }

  /**
   * @return PersistentCollection
   */
  public function getTasks(): PersistentCollection {
    return $this->tasks;
  }

  /**
   * @param PersistentCollection $tasks
   */
  public function setTasks(PersistentCollection $tasks): void {
    $this->tasks = $tasks;
  }

  /**
   * @return PersistentCollection
   */
  public function getMembers(): PersistentCollection {
    return $this->members;
  }

  /**
   * @return User
   */
  public function getOwner(): User {
    return $this->owner;
  }

  /**
   * @param User $owner
   */
  public function setOwner(User $owner): void {
    $this->owner = $owner;
  }


  /**
   * @param PersistentCollection $members
   */
  public function addMember(User $member): void {
    if (!$this->members->contains($member)) {
      $this->members[] = $member;
    }
  }

  /**
   * @param User $member
   */
  public function removeMember(User $member): void {
    if ($this->members->contains($member)) {
      $this->members->removeElement($member);
    }
  }

  /**
   * @param ProjectNote $note
   */
  public function addNote(ProjectNote $note): void {
    if(!$this->notes->contains($note)) {
      $this->notes[] = $note;
    }
  }

  /**
   * @param ProjectNote $note
   */
  public function removeNote(ProjectNote $note): void {
    if($this->notes->contains($note)) {
      $this->notes->removeElement($note);
    }
  }
}