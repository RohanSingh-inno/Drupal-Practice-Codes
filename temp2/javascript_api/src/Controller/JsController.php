<?php

namespace Drupal\javascript_api\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * This class will be used to display pages.
 */
class JsController extends ControllerBase {

  /**
   * This function will help to display a page.
   */
  public function page() {
    $build = [
      '#type' => 'markup',
      '#markup' => $this->t('Hi this text has CSS implimented'),
      '#attached' => [
        'library' => [
    // Include the custom library.
          'javascript_api/custom-style',
        ],
      ],
    ];
    // $build['#attached']['library'][] = 'javascript_api/custom-style';
    return $build;
  }

}

