<?php

namespace Drupal\gfi_auth_token\Authentication\Provider;

use Drupal\Core\Authentication\AuthenticationProviderInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class AuthTokenProvider.
 */
class AuthTokenProvider implements AuthenticationProviderInterface {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a HTTP basic authentication provider object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager) {
    $this->configFactory = $config_factory;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Checks whether suitable authentication credentials are on the request.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   *
   * @return bool
   *   TRUE if authentication credentials suitable for this provider are on the
   *   request, FALSE otherwise.
   */
  public function applies(Request $request) {

    $token = $request->query->get('token');

    if(isset($token)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function authenticate(Request $request) {

    $token = $request->query->get('token');

    if($user_id = $this->isCorrectToken($token)) {
      return $this->entityTypeManager->getStorage('user')->load($user_id);
    } else {
      throw new AccessDeniedHttpException();
    }
  }

  protected function isCorrectToken($token) {

    $query = \Drupal::entityQuery('auth_token')
      ->condition('token', $token, '=')
      ->condition('status', TRUE, '=');
    $token_ids = $query->execute();

    if(count($token_ids) === 1) {
      $token = $this->entityTypeManager->getStorage('auth_token')->load(current($token_ids));
      return $token->get('user_id')->target_id;
    } else {
      return false;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function cleanup(Request $request) {}

  /**
   * {@inheritdoc}
   */
  public function handleException(GetResponseForExceptionEvent $event) {
    $exception = $event->getException();
    if ($exception instanceof AccessDeniedHttpException) {
      $event->setException(
        new UnauthorizedHttpException('Invalid consumer origin.', $exception)
      );
      return TRUE;
    }
    return FALSE;
  }

}
