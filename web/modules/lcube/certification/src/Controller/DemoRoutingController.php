<?php

namespace Drupal\certification\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Routing\CurrentRouteMatch;

/**
 * Class DemoRoutingController.
 */
class DemoRoutingController extends ControllerBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Drupal\Core\Routing\CurrentRouteMatch definition.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * Constructs a new DemoRoutingController object.
   */
  public function __construct(Connection $database, CurrentRouteMatch $current_route_match) {
    $this->database = $database;
    $this->currentRouteMatch = $current_route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('current_route_match')
    );
  }

  /**
   * Basic.
   *
   * @return string
   *   Return Hello string.
   */
  public function basic() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Exemple de route basique avec entrée de menu principal')
    ];
  }

  /**
   * Local.
   *
   * @return string
   *   Return Hello string.
   */
  public function local() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Exemple de route basique avec entrée de menu local (Tabs)')
    ];
  }

  /**
   * @param $first
   * @param $second
   * @return mixed
   * @throws \Drupal\certification\Controller\AccessDeniedHttpException
   */
  public function argument($first, $second) {
    // Make sure you don't trust the URL to be safe! Always check for exploits.
    if (!is_numeric($first) || !is_numeric($second)) {
      // We will just show a standard "access denied" page in this case.
      throw new AccessDeniedHttpException();
    }

    $list[] = $this->t("First number was @number.", ['@number' => $first]);
    $list[] = $this->t("Second number was @number.", ['@number' => $second]);
    $list[] = $this->t('The total was @number.', ['@number' => $first + $second]);

    $render_array['page_example_arguments'] = [
      // The theme function to apply to the #items.
      '#theme' => 'item_list',
      // The list itself.
      '#items' => $list,
      '#title' => $this->t('Argument Information'),
    ];
    return $render_array;
  }

  public function upcast(AccountInterface $user) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Exemple de route basique avec argument et upcasting : '.$user->getDisplayName())
    ];
  }

}
