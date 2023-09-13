<?php 

namespace Drupal\register_with_otp\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RegisForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(){
    return 'register_with_otp_validation';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state){
    $current_user = \Drupal::currentUser();
    if ($current_user->isAuthenticated()) {
      \Drupal::messenger()->addMessage($this->t('You are already logged in'));
      $form_state->setRedirect('<front>');
      return $form;
    }
    /**
     * Field for otp.
     */
    $form['otp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('OTP'),
      '#required' => TRUE,
    ];
    /**
     * Continue button to submit and validate the form.
     */
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Continue'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state){
    $input_otp_value = $form_state->getValue('otp');
    $session = \Drupal::requestStack()->getCurrentRequest()->getSession();
    $otp_sent = $session->get('register_with_otp');
    if($input_otp_value != $otp_sent){
      $form_state->setErrorByName('otp',$this->t('Wrong OTP!!, Please enter the right OTP to login.'));
    }

  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state){
    $session = \Drupal::requestStack()->getCurrentRequest()->getSession();
    $session->remove('register_with_otp');
    $session->get('passed_value');
    $session->remove('passed_value');
    $form_state->setRedirect('user.login');
  }
}
