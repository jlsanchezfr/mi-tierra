<?php
/**
 * @file
 * Footer Information Block.
 */

namespace Drupal\blockview\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;  

/**
 * Provides a 'information block'
 * @Block(
 *   id = "InformationBlock",
 *   admin_label = @Translation("Information Block"),
 *   category = @Translation("MiTierra")
 * )   
 */
class InformationBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    //Retrieve existing configuration for this block.
    $config = $this->getConfiguration();

    //Add a form field to the existing block configuration form.
    $form['image'] = array(
      '#type' => 'image',
      '#title' => 'Image',
      '#default' => isset($config['image'])? $config['image'] : '',
    );
    $form['text'] = array(
      '#type' => 'text',
      '#title' => t('Body'),
      '#defautl_value' => isset($config['text'])? $config['text'] : '',
    );
    $form['cta'] = array(
      '#type' => 'link',
      '#title' => t('Buttom text'),
      '#default_value' => isset($config['cta'])? $config['cta'] : '',
    );
  }
  /**
  * {@inheritdoc}
  */
  public function blockSumbit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('image', $form_state->getValue('image'));
    $this->setConfigurationValue('text', $form_state->getValue('text'));
    $this->setConfigurationValue('link', $form_state->getValue('link'));
  }
  
  /**
  * {@inheritdoc}
  */
  public function build() {
    $config = $this->getConfiguration();

    $image = isset($config['image']) ?$config['image'] : '';
  }
}
