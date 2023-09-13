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
 *   id = "all_notice_block",
 *   admin_label = @Translation("All Notices"),
 *   category = @Translation("Custom")
 * )
 */
class allnotice extends BlockBase implements ContainerFactoryPluginInterface {

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
    // Get all the nodes which are notice
    $output = '';

    $query = $this->entityTypeManager->getStorage('node')
                ->getQuery()
                ->condition('type', 'notice')
                ->accessCheck(FALSE);

    $notice_ids = $query->execute();
    if(!empty($notice_ids)){
      $notices = $this->entityTypeManager->getStorage('node')->loadMultiple($notice_ids);
      foreach ($notices as $notice) {
        $output .= '<div class="notice">';
        $output .= '<h4>' . $notice->getTitle() . '</h4>';
        $output .= '<div>' . $notice->get('body')->value . '</div>';
        $output .= '<div>' . $notice->get('field_event__date')->value . '</div>';
        $output .= '</div>';
      }
    }
   

    return [
      '#markup' => $output,
    ];
  }
}


?>
