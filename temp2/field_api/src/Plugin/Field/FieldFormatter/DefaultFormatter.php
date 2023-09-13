<?php

namespace Drupal\field_api\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Template\Attribute;
/**
 * Plugin implementation of the 'color item' formatter.
 *
 * @FieldFormatter(
 *   id = "text_formatter",
 *   label = @Translation("Default Formatter"),
 *   field_types = {
 *     "new_filed_task"
 *   }
 * )
 */
class DefaultFormatter extends FormatterBase {

  /**
   * {@inheritDoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the color details.');
    return $summary;
  }

  /**
   * {@inheritDoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    foreach ($items as $delta => $item) {
      if ($items->hex_code) {
        $colorCode = $items->hex_code;
        $attributes = new Attribute();
        $attributes->setAttribute('style', 'color: ' . $colorCode);
        $element[$delta] = [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#value' => $colorCode,
          '#attributes' => $attributes->toArray(),
        ];
      }
      else {
        $red = $item->r;
        $green = $item->g;
        $blue = $item->b;
        $colorCode = 'rgb(' . $red . ', ' . $green . ', ' . $blue . ')';
        $element[$delta] = [
          '#type' => 'markup',
          '#markup' => $colorCode,
        ];
      }
    }
    return $element;
  }

}
