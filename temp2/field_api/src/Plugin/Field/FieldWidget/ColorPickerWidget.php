<?php

namespace Drupal\field_api\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Define the custom file widget.
 *
 * @FieldWidget(
 *   id = "first_widget",
 *   label = @Translation("RGB Widget"),
 *   description = @Translation("Defined for RGB field"),
 *   field_types = {
 *     "new_filed_task"
 *   }
 * )
 */
class ColorPickerWidget extends WidgetBase
{

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
  {
    $element['r'] = [
      '#type' => 'number',
      '#title' => $this->t('Red'),
      '#size' => '10',
      '#min' => 0,
      '#max' => 255,
      '#default_value' => $items[$delta]->r ?? NULL,
    ];
    $element['g'] = [
      '#type' => 'number',
      '#title' => $this->t('Green'),
      '#size' => '10',
      '#min' => 0,
      '#max' => 255,
      '#default_value' => $items[$delta]->g ?? NULL,
    ];
    $element['b'] = [
      '#type' => 'number',
      '#title' => $this->t('Blue'),
      '#size' => '10',
      '#min' => 0,
      '#max' => 255,
      '#default_value' => $items[$delta]->b ?? NULL,
    ];

    return $element;
  }
}

?>

