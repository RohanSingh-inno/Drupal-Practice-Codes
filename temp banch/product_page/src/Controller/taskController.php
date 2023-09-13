<?php 

namespace Drupal\product_page\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\File\Entity\File;
// use Drupal\Core\Entity\EntityTypeManagerInterface;


class taskController extends ControllerBase {

    function thnkuPage(Request $request){
        // Get the value from the query parameter.
       $value = $request->query->get('node_id');
       $quantity = 1;
       $user = \Drupal::CurrentUser()->getAccountName();
    //    dd($user);
       $query = \Drupal::entityTypeManager()->getStorage('node')->load($value);
       $pre = 'http://www.practice01.com/sites/default/files/2023-08/';
       $image = $query->get("field_product_image_")->getValue()[0];
       $val = $image['target_id'];
    //    dd($val);
       $image_name = File::load($val)->get('filename')->getValue()[0]['value'];
       
    //    dd($image_name);
       if(!empty($value)){
        $text = '<h1>Thank You '. $user.', For Trusting Us.</h1></br>';
        $text.= 'You have purchased '.$quantity.' '.$query->getTitle().'</br>';
        $text.= '<img src="'.$pre.$image_name.'" alt="'.$image['alt'].'" width="'.$image['width'].'" height="'.$image['height'].'">';
        return [
            '#type' => 'markup',
            '#markup' => $text,
        ];
       }
    }
}
