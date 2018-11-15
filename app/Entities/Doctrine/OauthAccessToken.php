<?php

namespace CodeProject\Entities\Doctrine;

class OauthAccessToken
{

  /**
   * @var string
   */
  protected $id;

  /**
   * @var int
   */
  protected $userId;

  /**
   * @var int
   */
  protected $clientId;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $scopes;

  /**
   * @var boolean
   */
  protected $revoked;

  /**
   * @var \DateTime
   */
  protected $createdAt;

  /**
   * @var \DateTime
   */
  protected $updatedAt;

  /**
   * @var \DateTime
   */
  protected $expiresAt;

}