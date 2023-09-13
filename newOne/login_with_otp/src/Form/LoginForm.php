<?php

namespace Drupal\login_with_otp\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a login_alter form.
 */
class LoginForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'login_with_otp_validation';
  }
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $current_user = \Drupal::currentUser();
    if ($current_user->isAuthenticated()) {
      \Drupal::messenger()->addMessage($this->t('You are already logged in'));
      $form_state->setRedirect('<front>');
      return $form;
    }
    $form['otp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('OTP'),
      '#required' => TRUE,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Continue'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $input_otp = $form_state->getValue('otp');
    $session = \Drupal::requestStack()->getCurrentRequest()->getSession();
    $otp_sent = $session->get('login_alter_otp');
    if($input_otp != $otp_sent) {
      $form_state->setErrorByName('otp',t('Invalid OTP'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $request = \Drupal::requestStack()->getCurrentRequest();
    $uid = $request->query->get('uid');
    $user = \Drupal::entityTypeManager()->getStorage('user')->load($uid);
    user_login_finalize($user);
    $session = \Drupal::requestStack()->getCurrentRequest()->getSession();
    $session->remove('login_alter_otp');
    $form_state->setRedirect('user.page');
  }

}
