<?php

namespace Drupal\database_event\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EventController extends ControllerBase
{
  public $database;
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }
  public function yearlyEventCount() {
    $query = \Drupal::database()->select('node__date','e')
      ->fields('e', ['date_value']);
    $result = $query->execute();

    $data = [];
    foreach($result as $value){
      $data[] = [
        'Date' => $value->date_value,
      ];
    }
    $newArr= [];
    foreach ($data as $key) {
      $temp = substr($key['Date'],0,4);
      array_push($newArr,$temp);
    }
    
    
    $header = array_keys(array_count_values($newArr));
    $row_value = array_values(array_count_values($newArr));
    
    $build['table'] = [
      '#type' => 'table',
      '#caption' => 'Yearly Count',
      '#header' => $header,
      '#rows' => [$row_value],
    ];
    return $build;
  }

  public function quarterEventCount() {
    $query = \Drupal::database()->select('node__date','e')
      ->fields('e', ['date_value']);
    $result = $query->execute();

    $data = [];
    $q1 = $q2 = $q3 = $q4 = 0;
    foreach($result as $value){
      $data[] = [
        'Date' => $value->date_value,
      ];
    }
    
    foreach ($data as $key) {
      $temp = substr($key['Date'],5,2);
      $temp2 = floor((int)$temp[1] / 3);
      if($temp2 == 0){
        $q1++;
      }elseif($temp2 == 1){
        $q2++;
      }elseif($temp2 == 2){
        $q3++;
      }else{
        $q4++;
      }
    }
    

    $header = array('Quarter-1','Quarter-2','Quarter-3','Quarter-4');
    $row_value = [$q1 , $q2 , $q3 , $q4];
    
    $build['table'] = [
      '#type' => 'table',
      '#caption' => 'Quarterly Count',
      '#header' => $header,
      '#rows' => [$row_value],
    ];
    return $build;
  }

  public function typeEventCount() {
    $query = \Drupal::database()->select('node__field_type','e')
      ->fields('e', ['field_type_value']);
    $result = $query->execute();

    $data = [];
    foreach($result as $value){
      $data[] = [
        'type' => $value->field_type_value,
      ];
    }

    $newArr= [];
    foreach ($data as $key) {
      array_push($newArr,$key['type']);
    }
    
    $header = array_keys(array_count_values($newArr));
    $row_value = array_values(array_count_values($newArr));
    
    $build['table'] = [
      '#type' => 'table',
      '#caption' => 'Event Type Count',
      '#header' => $header,
      '#rows' => [$row_value],
    ];
    return $build ;
  }

  public function show(){
    return [
      $this->yearlyEventCount() , $this->quarterEventCount() , $this->typeEventCount() , 
      '#title' => 'Dashboard',
    ];
    
  }
}

?>

