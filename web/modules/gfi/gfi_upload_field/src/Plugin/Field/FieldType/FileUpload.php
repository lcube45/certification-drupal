<?php

namespace Drupal\gfi_upload_field\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'gfi_file_upload' field type.
 *
 * @FieldType(
 *   id = "gfi_file_upload",
 *   label = @Translation("Gfi file upload"),
 *   description = @Translation("Gfi file upload"),
 *   default_widget = "gfi_file_upload_widget",
 *   default_formatter = "gfi_file_upload_formatter"
 * )
 */
class FileUpload extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'filename' => [
          'type' => 'varchar',
          'length' => 255,
        ]
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    $properties['filename'] = DataDefinition::create('string')
      ->setLabel(t('Text'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('filename')->getValue();
    return $value === NULL || $value === '';
  }

}
