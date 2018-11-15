<?php

namespace CodeProject\Mappings;


use CodeProject\Entities\Doctrine\OauthRefreshToken;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class OauthRefreshTokenMapping extends EntityMapping {


  /**
   * Returns the fully qualified name of the class that this mapper maps.
   *
   * @return string
   */
  public function mapFor() {
    return OauthRefreshToken::class;
  }

  /**
   * Load the object's metadata through the Metadata Builder object.
   *
   * @param Fluent $builder
   */
  public function map(Fluent $builder) {
    $builder->table('oauth_refresh_tokens');
    $builder->string('id')->length(100)->primary();
    $builder->string('accessTokenId')->name('access_token_id')->length(100);
    $builder->index('access_token_id');
    $builder->boolean('revoked');
    $builder->carbonDateTime('expiresAt')->name('expires_at')->nullable();
  }
}