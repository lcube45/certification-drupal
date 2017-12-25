<?php

namespace Drupal\gfi_auth_token\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Auth token entity.
 *
 * @ingroup gfi_auth_token
 *
 * @ContentEntityType(
 *   id = "auth_token",
 *   label = @Translation("Auth token"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\gfi_auth_token\AuthTokenListBuilder",
 *     "views_data" = "Drupal\gfi_auth_token\Entity\AuthTokenViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\gfi_auth_token\Form\AuthTokenForm",
 *       "add" = "Drupal\gfi_auth_token\Form\AuthTokenForm",
 *       "edit" = "Drupal\gfi_auth_token\Form\AuthTokenForm",
 *       "delete" = "Drupal\gfi_auth_token\Form\AuthTokenDeleteForm",
 *     },
 *     "access" = "Drupal\gfi_auth_token\AuthTokenAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\gfi_auth_token\AuthTokenHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "auth_token",
 *   admin_permission = "administer auth token entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "token" = "token",
 *     "user_id" = "user_id",
 *     "resource_id" = "resource_id",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/auth_token/{auth_token}",
 *     "add-form" = "/admin/structure/auth_token/add",
 *     "edit-form" = "/admin/structure/auth_token/{auth_token}/edit",
 *     "delete-form" = "/admin/structure/auth_token/{auth_token}/delete",
 *     "collection" = "/admin/structure/auth_token",
 *   },
 *   field_ui_base_route = "auth_token.settings"
 * )
 */
class AuthToken extends ContentEntityBase implements AuthTokenInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'uid' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  public function token() {

  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Auth Token entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Auth Token entity.'))
      ->setReadOnly(TRUE);

    $fields['uid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Auth token entity.'))
      ->setReadOnly(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of Note entity.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Auth token is published.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'checkbox',
        'weight' => 10
      ));

    $fields['token'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Token'))
      ->setRequired(TRUE)
      ->setDescription(t('The token entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Granted user'))
      ->setRequired(TRUE)
      ->setDescription(t('The user ID of the granted user by the token'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['resource_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Protected resource'))
      ->setRequired(TRUE)
      ->setDescription(t('The protected resource ID'))
      ->setSetting('target_type', 'node')
      ->setSetting('handler', 'default')
      ->setSetting('handler_settings', ['target_bundles' => ['article' => 'article']])
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE);

    return $fields;
  }

}
