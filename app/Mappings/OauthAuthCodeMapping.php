<?php

namespace CodeProject\Mappings;


use CodeProject\Entities\Doctrine\OauthAuthCode;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class OauthAuthCodeMapping extends EntityMapping {

  public function mapFor() {
    return OauthAuthCode::class;
  }
  
  public function map(Fluent $builder) {
    $builder->table('oauth_auth_codes');
    $builder->string('id')->length(100)->primary();
    $builder->integer('userId')->name('user_id');
    $builder->integer('clientId')->name('client_id');
    $builder->text('scopes')->nullable();
    $builder->boolean('revoked');
    $builder->carbonDateTime('expiresAt')->name('expires_at')->nullable();
  }

}