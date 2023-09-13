<?php

namespace Drupal\field_api\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Define the custom field type.
 * 
 * @FieldType(
 *   id = "new_filed_task",
 *   label = @Translation("New Field Task"),
 *   description = @Translation("Creating an RGB and hex code field"),
 *   category = @Translation("Custom"),
 *   default_widget = "first_widget",
 *   default_formatter = "text_formatter",
 * )
 */
class ColorPicker extends FieldItemBase {

  /**
   * {@inheritDoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'hex_code' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
        ],
        'r' => [
          'type' => 'int',
          'size' => 'small',
          'not null' => FALSE,
        ],
        'g' => [
          'type' => 'int',
          'size' => 'small',
          'not null' => FALSE,
        ],
        'b' => [
          'type' => 'int',
          'size' => 'small',
          'not null'=>FALSE,
        ],
      ],
    ];
    
  }

  /**
   * {@inheritDoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    $properties = [];

    $properties['hex_code']  = DataDefinition::create('string')
    ->setLabel(t('Hex Code'));

    $properties['r'] = DataDefinition::create('integer')
    ->setLabel("Red");

    $properties['g'] = DataDefinition::create('integer')
    ->setLabel('Green');

    $properties['b'] = DataDefinition::create('integer')
    ->setLabel('Blue');

    return $properties;

  }
}
