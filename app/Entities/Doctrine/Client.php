<?php

namespace CodeProject\Entities\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use DateTime;

class Client implements \JsonSerializable {
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $responsible;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $obs;

    /**
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
     */
    private $updated_at;

    /**
     * @var Projects[] ArrayCollection of projects
     */
    private $projects;

    public function __construct($name, $responsible, $email, $phone, $address, $obs) {
        $this->name = $name;
        $this->responsible = $responsible;
        $this->address = $address;
        $this->email = $email;
        $this->obs = $obs;
        $this->phone = $phone;
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
            'obs' => $this->obs
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
            'obs' => $this->obs
        ];
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
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
    public function getResponsible(): string {
        return $this->responsible;
    }

    /**
     * @param string $responsible
     */
    public function setResponsible(string $responsible): void {
        $this->responsible = $responsible;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getAddress(): string {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getObs(): string {
        return $this->obs;
    }

    /**
     * @param string $obs
     */
    public function setObs(string $obs): void {
        $this->obs = $obs;
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

    public function getProjects(): PersistentCollection {
        return $this->projects;
    }

    public function setProjects($projects): void {
        $this->projects = $projects;
    }


}