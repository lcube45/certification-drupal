<?php

namespace Drupal\gfi_auth_token\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Auth token entities.
 */
class AuthTokenViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
