<?php
/**
* @file
* A custom Hello person block
*/
namespace Drupal\custom_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;  
/**
* Provides a 'Custom block'
* @Block(
*   id = "hello_block",
*   admin_label = @Translation("Hello Block"),
*   category = @Translation("Custom Blocks")
* )   
*/
class HelloPersonBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    //Retrieve existing configuration for this block
    $config = $this->getConfiguration();

    //Add a form field to the existing block configuration form
    $form['person_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name:'),
      '#default_value' => isset($config['person_name'])? $config['person_name'] : '',
    );
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    //Save our custom settings when the form is submitted.
    $this->setConfigurationValue('person_name',$form_state->getValue('person_name'));
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    $person_name = isset($config['person_name']) ? $config['person_name'] : '';

    return array(
      '#markup' => $this->t('Hello, @person', array('@person'=>$person_name)),
    );
  }
}