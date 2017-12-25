<?php

namespace Drupal\gfi_auth_token\Form;

use Drupal\Component\Utility\Crypt;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Auth token edit forms.
 *
 * @ingroup gfi_auth_token
 */
class AuthTokenForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\gfi_auth_token\Entity\AuthToken */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    if($entity->isNew()) {
      $entity->set('token', Crypt::randomBytesBase64());
    }

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Auth token.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Auth token.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.auth_token.collection');
  }

}
