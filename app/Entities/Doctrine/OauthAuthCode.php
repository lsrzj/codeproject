<?php

namespace CodeProject\Entities\Doctrine;

class OauthAuthCode {

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
  protected $scopes;

  /**
   * @var boolean
   */
  protected $revoked;

  /**
   * @var \DateTime
   */
  protected $expiresAt;

}