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

    $element['filename'] = [
      '#type' => 'file',
      '#title' => 'filename',
      '#size' => 60,
      '#multiple' => TRUE,
    ];

    $element['test'] = [
        '#type' => 'textfield',
        '#title' => 'filename',
        '#size' => 60,
      ];

    return $element;
  }

  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    return $values;
  }

  public static function value($element, $input = FALSE, FormStateInterface $form_state) {
    return 'cool';
  }
}
