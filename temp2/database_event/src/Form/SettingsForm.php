<?php

namespace Drupal\database_event\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Url;
// use Drupal\taxonomy\Entity\Term;
// use Drupal\views\Plugin\views\field\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Database APi Taxonomy term search form.
 */
class SettingsForm extends FormBase {
  /**
   * Contains the database connection object for database handling.
   * 
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  protected $EntityTypeManager;
  /**
   * Constructs the database connection object.
   * 
   * @param \Drupal\Core\Database\Connection $connection
   *   Contains the Connection class object.
   */
  public function __construct(Connection $connection , EntityTypeManagerInterface $EntityTypeManager) {
    $this->connection = $connection;
    $this->EntityTypeManager = $EntityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'SettingsForm_taxonomy';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['term'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Write the Term Name'),
      '#default_value' => $form_state->getValue('term'),
      '#description' => $this->t('Its Case Sensitive'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Search'),
      ],
    ];

    return $form;
  }

  
  

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    try {
      $query = $this->connection->select('taxonomy_term_field_data', 'ttfd');
      $query->innerjoin('taxonomy_term_data', 'ttd', 'ttfd.tid = ttd.tid');
      $query->innerJoin('taxonomy_index', 'ti', 'ttd.tid = ti.tid');
      $query->innerJoin('node_field_data', 'nfd', 'ti.nid = nfd.nid');
      $query->fields('ttd', ['tid', 'uuid']);
      $query->fields('ttfd', ['name']);
      $query->fields('nfd', ['title']);
      $query->fields('nfd', ['nid']);
      $query->condition('ttfd.name', $form_state->getValue('term'));
      $result = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
    }
    catch (\Exception $e) {
      $this->messenger()->addMessage('Something wrong happened');
    }

    // dd($result);
    if ($result) {
      $this->messenger()->addMessage($this->t('Term @term has ID: @id', 
        ['@term' => $form_state->getValue('term'), '@id' => $result[0]['tid']]));
      $this->messenger()->addMessage($this->t('Term @term has UUID: @uuid', 
        ['@term' => $form_state->getValue('term'), '@uuid' => $result[0]['uuid']]));
      $nodeUrl = Url::fromUri('internal:/node/' . $result[0]['nid'])->toString();
      $this->messenger()->addMessage($this->t('Node Url is : @URL', 
        ['@URL' => $nodeUrl]));
      $this->messenger()->addMessage($this->t('Term @term has been used in node with title: @title', 
        ['@term' => $form_state->getValue('term'), '@title' => $result[0]['title']]));
    }
    else {
      $form_state->setErrorByName('term_name', $this->t("Term @term doesn't exit", 
        ['@term' => $form_state->getValue('term_name')]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    
  }
}
