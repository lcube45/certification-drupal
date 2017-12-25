<?php

namespace Drupal\cache\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManager;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityManager definition.
   *
   * @var \Drupal\Core\Entity\EntityManager
   */
  protected $entityManager;
  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * Constructs a new DefaultController object.
   */
  public function __construct(EntityManager $entity_manager, AccountProxy $current_user) {
    $this->entityManager = $entity_manager;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager'),
      $container->get('current_user')
    );
  }

  /**
   * Demo.
   *
   * @return string
   *   Return Hello string.
   */
  public function demo() {

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: demo cool')
    ];
  }

}
