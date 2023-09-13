<?php

namespace Drupal\entity_movie\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
// composer requrie drupal/examples 
/**
 * Entity movie form.
 *
 * @property \Drupal\entity_movie\EntityMovieInterface $entity
 */
class EntityMovieForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $form = parent::form($form, $form_state);

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->get('name'),
      '#description' => $this->t('Name of the movie.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\entity_movie\Entity\EntityMovie::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    // $form['status'] = [
    //   '#type' => 'checkbox',
    //   '#title' => $this->t('Enabled'),
    //   '#default_value' => $this->entity->status(),
    // ];

    $form['award'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Award'),
      '#default_value' => $this->entity->get('award'),
      '#description' => $this->t('Award given to the movie.'),
    ];

    $form['date'] = [
      '#type' => 'date',
      '#title' => $this->t('Date'),
      '#default_value' => $this->entity->get('date'),
      '#description' => $this->t('Date on which award was given'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $message = $result == SAVED_NEW
      ? $this->t('Created new entity movie %label.', $message_args)
      : $this->t('Updated entity movie %label.', $message_args);
    $this->messenger()->addStatus($message);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
