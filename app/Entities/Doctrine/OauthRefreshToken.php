<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 15/11/18
 * Time: 01:11
 */

namespace CodeProject\Entities\Doctrine;


class OauthRefreshToken
{

  /**
   * @var string
   */
  protected $id;

  /**
   * @var int
   */
  protected $accessTokenId;

  /**
   * @var boolean
   */
  protected $revoked;

  /**
   * @var \DateTime
   */
  protected $expiresAt;

}