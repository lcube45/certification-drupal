<?php

namespace Drupal\gfi_auth_token\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Auth token entities.
 *
 * @ingroup gfi_auth_token
 */
interface AuthTokenInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Auth token creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Auth token.
   */
  public function getCreatedTime();

  /**
   * Sets the Auth token creation timestamp.
   *
   * @param int $timestamp
   *   The Auth token creation timestamp.
   *
   * @return \Drupal\gfi_auth_token\Entity\AuthTokenInterface
   *   The called Auth token entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Auth token published status indicator.
   *
   * Unpublished Auth token are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Auth token is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Auth token.
   *
   * @param bool $published
   *   TRUE to set this Auth token to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\gfi_auth_token\Entity\AuthTokenInterface
   *   The called Auth token entity.
   */
  public function setPublished($published);

}
