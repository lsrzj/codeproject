<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 15/11/18
 * Time: 01:04
 */

namespace CodeProject\Mappings;


use CodeProject\Entities\Doctrine\OauthAccessToken;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class OauthAccessTokenMapping extends EntityMapping {

  public function mapFor() {
    return OauthAccessToken::class;
  }

  public function map(Fluent $builder) {
    $builder->table('oauth_access_tokens');
    $builder->string('id')->length(100)->primary();
    $builder->integer('userId')->name('user_id')->nullable();
    $builder->index('user_id');
    $builder->integer('clientId')->name('client_id');
    $builder->string('name')->nullable();
    $builder->text('scopes')->nullable();
    $builder->boolean('revoked');
    $builder->carbonDateTime('createdAt')->name('created_at')->timestampable()->onCreate();
    $builder->carbonDateTime('updatedAt')->name('updated_at')->timestampable()->onUpdate();
    $builder->carbonDateTime('expiresAt')->name('expires_at')->nullable();
  }
}