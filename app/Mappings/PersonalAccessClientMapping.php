<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 15/11/18
 * Time: 01:26
 */

namespace CodeProject\Mappings;


use CodeProject\Entities\Doctrine\OauthPersonalAccessClient;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class PersonalAccessClientMapping extends EntityMapping {

  /**
   * Returns the fully qualified name of the class that this mapper maps.
   *
   * @return string
   */
  public function mapFor() {
    return OauthPersonalAccessClient::class;
  }

  /**
   * Load the object's metadata through the Metadata Builder object.
   *
   * @param Fluent $builder
   */
  public function map(Fluent $builder) {
    $builder->table('oauth_personal_access_clients');
    $builder->increments('id');
    $builder->integer('clientId')->name('client_id');
    $builder->index('client_id');
    $builder->carbonDateTime('createdAt')->name('created_at')->timestampable()->onCreate();
    $builder->carbonDateTime('updatedAt')->name('updated_at')->timestampable()->onUpdate();
  }
}