<?php

namespace Drupal\api_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\taxonomy\Entity\Term;

/**
 * This class will be used to return data in the form of API.
 */
class StudentApiController extends ControllerBase {

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
  public function getAllStudentDetails() {
    $query = $this->entityTypeManager
      ->getStorage('user')
      ->getQuery()
      ->condition('roles', 'student')
      ->accessCheck(FALSE);

    $student_ids = $query->execute();

    $students = $this->entityTypeManager
      ->getStorage('user')
      ->loadMultiple($student_ids);

    return $students;
  }

  /**
   * Function to display all the details regarding students.
   */
  public function listStudents() {
    // Fetch and format student data here.
    $students = [];

    $all_students = $this->getAllStudentDetails();
    
  
    foreach ($all_students as $key => $student) {
      $students[$key]['Name'] = $student->get('field_full_name')->getValue()[0]['value'];
      $students[$key]['Email'] = $student->getEmail();
      $students[$key]['Phone Number'] = $student->get('field_phone_number')->getValue()[0]['value'];

      $taxonomy_term_id = $student->get('field_stream')->getValue()[0]['target_id'];
      $term = Term::load($taxonomy_term_id)->label();
      $students[$key]['Stream'] = $term;

      $students[$key]['Joining Year'] = $student->get('field_joining_year')->getValue()[0]['value'];
      $students[$key]['Passing Year'] = $student->get('field_passing_year')->getValue()[0]['value'];
    }

    return new JsonResponse($students);
  }

}



// $query = $entity_type_manager->getStorage('user')
//   ->getQuery()
//   ->condition('roles', 'student') // Filter by role
//   ->condition('field_graduation_date', $six_months_ago, '<'); // Assuming 'field_graduation_date' is your graduation date field.

// $uids = $query->execute();
// if (!empty($uids)) {
//   $user_storage = $entity_type_manager->getStorage('user');
//   $students = $user_storage->loadMultiple($uids);
//   foreach ($students as $student) {
//     $student->delete();
//   }
// }
// }

// $query = \Drupal::entityQuery('user')
//     ->condition('roles', 'student') // Filter by role
//     ->condition('field_graduation_date', $six_months_ago, '<'); // Assuming 'field_graduation_date' is your graduation date field.

//   $uids = $query->execute();
//   if (!empty($uids)) {
//     $storage = \Drupal::entityTypeManager()->getStorage('user');
//     $students = $storage->loadMultiple($uids);
//     foreach ($students as $student) {
//       $student->delete();
//     }
//   }
