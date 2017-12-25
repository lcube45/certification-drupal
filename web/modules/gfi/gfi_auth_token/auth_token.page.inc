<?php

/**
 * @file
 * Contains auth_token.page.inc.
 *
 * Page callback for Auth token entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Auth token templates.
 *
 * Default template: auth_token.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_auth_token(array &$variables) {
  // Fetch AuthToken Entity Object.
  $auth_token = $variables['elements']['#auth_token'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
