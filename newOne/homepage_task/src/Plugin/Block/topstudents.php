<?php

namespace Drupal\homepage_task\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom block to display top 5 active students.
 *
 * @Block(
 *   id = "top_active_students_block",
 *   admin_label = @Translation("Top 5 Active Students"),
 *   category = @Translation("Custom")
 * )
 */
class topstudents extends BlockBase implements ContainerFactoryPluginInterface {

  protected $entityTypeManager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  public function build() {
    // Get the top 5 active student names.
    $output = '';

    $query = $this->entityTypeManager->getStorage('user')
      ->getQuery()
      ->condition('status', 1)
      ->condition('roles', 'student')
      ->pager(5)
      ->sort('access', 'DESC')
      ->accessCheck(TRUE);

    $student_ids = $query->execute();
    if(!empty($student_ids)){
      $students = $this->entityTypeManager->getStorage('user')->loadMultiple($student_ids);

      foreach ($students as $student) {
        $output .= $student->get('name')->value . '<br>';
      }
    }
   

    return [
      '#markup' => $output,
    ];
  }
}

?>

