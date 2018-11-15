<?php

namespace CodeProject\Mappings;

use CodeProject\Entities\Doctrine\OauthClient;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class OauthClientMapping extends EntityMapping {


  /**
   * Returns the fully qualified name of the class that this mapper maps.
   *
   * @return string
   */
  public function mapFor() {
    return OauthClient::class;
  }

  /**
   * Load the object's metadata through the Metadata Builder object.
   *
   * @param Fluent $builder
   */
  public function map(Fluent $builder) {
    $builder->table('oauth_clients');
    $builder->increments('id');
    $builder->integer('userId')->name('user_id')->nullable();
    $builder->index('user_id');
    $builder->string('name');
    $builder->string('secret')->length(100);
    $builder->text('redirect');
    $builder->boolean('personalAccessClient')->name('personal_access_client');
    $builder->boolean('passwordClient')->name('password_client');
    $builder->boolean('revoked');
    $builder->carbonDateTime('createdAt')->name('created_at')->timestampable()->onCreate();
    $builder->carbonDateTime('updatedAt')->name('updated_at')->timestampable()->onUpdate();
  }
}