<?php

namespace Drupal\gfi_auth_token;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Auth token entities.
 *
 * @ingroup gfi_auth_token
 */
class AuthTokenListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['token'] = $this->t('Token');
    $header['user'] = $this->t('Granted user id');
    $header['resource'] = $this->t('Granted resource id');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\gfi_auth_token\Entity\AuthToken */
    $row['token'] = $entity->get('token')->value;
    $row['user'] = $entity->get('user_id')->target_id;
    $row['resource'] = $entity->get('resource_id')->target_id;


    return $row + parent::buildRow($entity);
  }

}
