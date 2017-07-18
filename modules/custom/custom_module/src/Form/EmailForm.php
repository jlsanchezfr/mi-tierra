<?php
/**
* @file
* Contains \Drupal\custom_module\Form\EmailForm
*/

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class EmailForm extends ConfigFormBase {
  /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'email_form';
  }
  /**
  * {@inheritdoc}
  */

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form =parent::buildForm($form, $form_state);

    $config = $this->config('email.settings');

    $form['email']= array(
      '#type' => 'email',
      '#title' => $this->t('You .com email address.'),
      '#default_value' => $config->get('email.email_address')
    );
    return $form;
  }
  /**
  * {@inheritdoc}
  */

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if(strpos($form_state->getValue('email'), '.com')===FALSE) {
      $form_state->setErrorByName('email', $this->t('This is not a .com email address.'));
    }
  }

  /**
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('email.settings');
    $config->set('email.email_address', $form_state->getValue('email'));
    $config->save();

    return parent::submitForm($form, $form_state);
  }

  /**
  * {@inheritdoc}
  */
  protected function getEditableConfigNames() {
    return [
      'email.settings',
    ];
  }
}
