<?php

namespace Drupal\gfi_auth_token;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Auth token entity.
 *
 * @see \Drupal\gfi_auth_token\Entity\AuthToken.
 */
class AuthTokenAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\gfi_auth_token\Entity\AuthTokenInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished auth token entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published auth token entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit auth token entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete auth token entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add auth token entities');
  }

}
