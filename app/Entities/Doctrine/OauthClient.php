<?php

namespace CodeProject\Entities\Doctrine;


class OauthClient {

  /**
   * @var int
   */
  protected $id;

  /**
   * @var int
   */
  protected $userId;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $secret;

  /**
   * @var string
   */
  protected $redirect;

  /**
   * @var boolean
   */
  protected $personalAccessClient;

  /**
   * @var boolean
   */
  protected $passwordClient;

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
}