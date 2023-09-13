<?php

  namespace Drupal\blocks_module\Plugin\Block;
  
  use Drupal\Core\Block\BlockBase;
  
  /**
   * Provides a custom block.
   *
   * @Block(
   *   id = "block_module",
   *   admin_label = @Translation("Block Module"),
   *   category = @Translation("Block Module")
   * )
   */
  class BlocksModule extends BlockBase
  {
    /**
     * {@inheritDoc}
     */
    public function build()
    {
      $user = \Drupal::currentUser()->getAccountName();
      return[
        '#markup' => $this->t('Welcome @user!',['@user' => $user])
      ];
    }
  
  }

?>
