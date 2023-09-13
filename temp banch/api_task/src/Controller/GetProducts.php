<?php

namespace Drupal\api_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\taxonomy\Entity\Term;
use Drupal\File\Entity\File;

/**
 * This class will be used to return data in the form of API.
 */
class GetProducts extends ControllerBase {

  public $entityTypeManager;
  /**
   * Constructor for your class.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Container function.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   This is for dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Get all student details.
   */
  public function getAllProductDetails() {
    $query = $this->entityTypeManager
      ->getStorage('node')
      ->getQuery()
      ->condition('type', 'products')
      ->accessCheck(TRUE);

    $product_ids = $query->execute();

    $products = $this->entityTypeManager
      ->getStorage('node')
      ->loadMultiple($product_ids);

    return $products;
  }

  /**
   * Function to display all the details regarding students.
   */
  public function getProduct() {
    // Fetch and format student data here.
    $products = [];

    $all_products = $this->getAllProductDetails();
    
    
    foreach ($all_products as $key => $product) {
      $products[$key]['Product Name'] = $product->get('title')->getValue()[0]['value'];
      $products[$key]['Description'] = $product->get('body')->getValue()[0]['value'];
      $products[$key]['Price'] = $product->get('field_price')->getValue()[0]['value'];

      $taxonomy_term_id = $product->get('field_categories')->getValue()[0]['target_id'];
      $term = Term::load($taxonomy_term_id)->label();
      
      $products[$key]['Category'] = $term;

      $pre = 'http://www.practice01.com/sites/default/files/2023-08/';
      $image_term_id = $product->get('field_product_image_')->getValue()[0]['target_id'];
      $image = File::load($image_term_id)->get('filename')->getValue()[0]['value'];

      $products[$key]['Product Image'] = $pre . $image;
      
    }

    return new JsonResponse($products);
  }

}
