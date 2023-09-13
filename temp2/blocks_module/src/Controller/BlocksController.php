<?php

  namespace Drupal\blocks_module\Controller;
  
  use Drupal\Core\Controller\ControllerBase;
  
  /**
   * Class for showing the pages.
   */
  class BlocksController extends ControllerBase
  {
    /**
     * Display the markup.
     *
     * @return array
     *   Return markup array.
     */
    public function welcomePage()
    {
      return [
        '#type' => '#markup',
        '#markup' => ' '
      ];
    }
  }

?>
