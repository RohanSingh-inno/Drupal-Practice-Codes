<?php

namespace Drupal\entity_movie;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of entity movies.
 */
class EntityMovieListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['Name'] = $this->t('name');
    $header['Id'] = $this->t('Machine name');
    $header['Award'] = $this->t('award');
    $header['Date'] = $this->t('date');
    // $header['status'] = $this->t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\entity_movie\EntityMovieInterface $entity */
    $row['Name'] = $entity->get('name');
    $row['Id'] = $entity->id();
    $row['Award'] = $entity->get('award');
    $row['Date'] = $entity->get('date');
    return $row + parent::buildRow($entity);
  }

}
