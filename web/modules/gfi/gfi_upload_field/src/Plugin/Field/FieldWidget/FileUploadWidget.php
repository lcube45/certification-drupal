<?php

namespace Drupal\gfi_upload_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'gfi_file_upload_widget' widget.
 *
 * @FieldWidget(
 *   id = "gfi_file_upload_widget",
 *   label = @Translation("File upload widget"),
 *   field_types = {
 *     "gfi_file_upload"
 *   }
 * )
 */
class FileUploadWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['filename'] = $element + [
      '#type' => 'textfield',
      '#title' => 'filename',
      '#default_value' => isset($items[$delta]->filename) ? $items[$delta]->filename : NULL,
      '#size' => 60,
      '#maxlength' => 128,
    ];

    return $element;
  }
}
