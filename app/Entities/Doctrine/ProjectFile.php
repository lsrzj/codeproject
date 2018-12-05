<?php

namespace CodeProject\Entities\Doctrine;


class ProjectFile implements \JsonSerializable {

  private $id;
  /**
   * @var string
   */
  private $name;
  /**
   * @var string
   */
  private $extension;
  /**
   * @var string
   */
  private $description;

  /**
   * @var Project $project
   */
  private $project;

  /**
   * @var \DateTime
   */
  private $created_at;

  /**
   * @var \DateTime
   */
  private $updated_at;


  /**
   * ProjectFile constructor.
   * @param string $name
   * @param string $extension
   * @param string $description
   * @param Project $project
   */
  public function __construct(string $name, string $extension, string $description, Project $project) {
    $this->name = $name;
    $this->extension = $extension;
    $this->description = $description;
    $this->project = $project;
  }

  public function jsonSerialize() {
    // TODO: Implement jsonSerialize() method.
  }

  /**
   * @return mixed
   */
  public function getId() {
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
  public function getExtension(): string {
    return $this->extension;
  }

  /**
   * @param string $extension
   */
  public function setExtension(string $extension): void {
    $this->extension = $extension;
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
   * @return \DateTime
   */
  public function getCreatedAt(): \DateTime {
    return $this->created_at;
  }

  /**
   * @return \DateTime
   */
  public function getUpdatedAt(): \DateTime {
    return $this->updated_at;
  }

}