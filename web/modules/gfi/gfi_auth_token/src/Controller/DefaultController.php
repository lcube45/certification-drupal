<?php

namespace Drupal\gfi_auth_token\Controller;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Entity\EntityManager;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;
  /**
   * Drupal\Core\Entity\EntityManager definition.
   *
   * @var \Drupal\Core\Entity\EntityManager
   */
  protected $entityManager;

  /**
   * Constructs a new DefaultController object.
   */
  public function __construct(AccountProxy $current_user, EntityManager $entity_manager) {
    $this->currentUser = $current_user;
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
      $container->get('entity.manager')
    );
  }

  /**
   * Demo.
   *
   * @return string
   *   Return Hello string.
   */
  public function demo() {

    $current_user = $this->currentUser->getAccountName();

    return [
      '#type' => 'markup',
      '#markup' => 'Utilisateur identifié : ' . $current_user,
      '#cache' => ['max-age' => 0],
    ];
  }

}
