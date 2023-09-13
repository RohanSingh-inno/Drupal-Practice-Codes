<?php

namespace Drupal\entity_movie\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\entity_movie\EntityMovieInterface;

/**
 * Defines the entity movie entity type.
 *
 * @ConfigEntityType(
 *   id = "entity_movie",
 *   label = @Translation("Entity movie"),
 *   label_collection = @Translation("Entity movies"),
 *   label_singular = @Translation("entity movie"),
 *   label_plural = @Translation("entity movies"),
 *   label_count = @PluralTranslation(
 *     singular = "@count entity movie",
 *     plural = "@count entity movies",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\entity_movie\EntityMovieListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_movie\Form\EntityMovieForm",
 *       "edit" = "Drupal\entity_movie\Form\EntityMovieForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "entity_movie",
 *   admin_permission = "administer entity_movie",
 *   links = {
 *     "collection" = "/admin/structure/entity-movie",
 *     "add-form" = "/admin/structure/entity-movie/add",
 *     "edit-form" = "/admin/structure/entity-movie/{entity_movie}",
 *     "delete-form" = "/admin/structure/entity-movie/{entity_movie}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "name"="name",
 *     "award"="award"
 *   },
 *   config_export = {
 *     "id",
 *     "name",
 *     "award"
 *   }
 * )
 */
class EntityMovie extends ConfigEntityBase implements EntityMovieInterface {

  /**
   * The entity movie ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The entity movie label.
   *
   * @var string
   */
  // protected $label;

  /**
   * The entity_movie description.
   *
   * @var string
   */
  protected $name;

  /**
   * The entity_movie description.
   *
   * @var string
   */
  protected $award;

}
