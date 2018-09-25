<?php

namespace CodeProject\Entities\Doctrine;

use Doctrine\ORM\PersistentCollection;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

class User implements
    AuthorizableContract,
    CanResetPasswordContract,
    \JsonSerializable {
    use Authorizable,
        CanResetPassword,
        \LaravelDoctrine\ORM\Auth\Authenticatable;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $remember_token;

    /**
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
     */
    private $updated_at;

    /**
     * @var PersistentCollection
     */
    private $projects;

    /**
     * @var ArrayCollection
     */
    private $memberProjects;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
        $this->projects = new ArrayCollection();
        $this->memberProjects = new ArrayCollection();
    }

    public function __toString() {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ], JSON_UNESCAPED_UNICODE);
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function getKey() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRememberToken(): string {
        return $this->rememberToken;
    }

    /**
     * @param string $rememberToken
     */
    public function setRememberToken($rememberToken): void {
        $this->rememberToken = $rememberToken;
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
     * @return email
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param email $email
     */
    public function setEmail(string $email): void {
        $this->email = $email;
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
     * @return PersistentCollection
     */
    public function getProjects(): PersistentCollection {
        return $this->projects;
    }

    /**
     * @param PersistentCollection $projects
     */
    public function setProjects(PersistentCollection $projects): void {
        $this->projects = $projects;
    }

    /**
     * @return ArrayCollection
     */
    public function getMemberProjects(): ArrayCollection {
        return $this->memberProjects;
    }

    /**
     * @param ArrayCollection $memberProjects
     */
    public function setMemberProjects(ArrayCollection $memberProjects): void {
        $this->memberProjects = $memberProjects;
    }
}