<?php
/**
 * @file
 * BlockView Class.
 */

namespace Drupal\blockview\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;  

/**
 * Provides a 'blockview'
 * @Block(
 *   id = "BlockView",
 *   admin_label = @Translation("Block View"),
 *   category = @Translation("MiTierra")
 * )   
 */
class BlockView extends BlockBase {
  /**
   * {@inheritdoc}
   */

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();

    // Add a form field to the existing block configuration form.
    $form['style'] = array(
      '#type' => 'select',
      '#title' => t('Style'),
      '#options' => $this->getBlockViewStyles(),
      '#required' => true,
      '#default_value' => isset($config['style'])? $config['style'] : '',
    );
    $form['category_tid'] = array(
      '#type' => 'select',
      '#title' => t('Category'),
      '#options' => $this->getTaxonomyOptions(),
      '#default_value' => isset($config['category_tid'])? $config['category_tid'] : 0,
    );
    $form['items'] = array(
      '#type' => 'select',
      '#title' => t('Items to Show'),
      '#options' => [
        1 => 1, 
        2 => 2, 
        3 => 3, 
        4 => 4, 
        5 => 5, 
        6 => 6, 
        7 => 7, 
        8 => 8
      ],
      '#required' => true,
      '#default_value' => isset($config['items'])? $config['items'] : 1,
    );
    return $form;
  }

  private function getTaxonomyOptions() {
    $options = [];
    $vid = 'categories';
    if (($terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid, 0, NULL, TRUE))) {
      foreach ($terms as $term) {
        $options[$term->id()] = $term->get('name')->value;
      }
    }

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('view_name',$form_state->getValue('view_name'));
    $this->setConfigurationValue('category_tid',$form_state->getValue('category_tid'));
    $this->setConfigurationValue('items',$form_state->getValue('items'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    $view_name = isset($config['view_name']) ? $config['view_name'] : false;
    if (!$view_name) {
      return false;
    }
    $category_id = isset($config['category_tid']) ? $config['category_tid'] : 0;
    $items = isset($config['items']) ? $config['items'] : 1;

    return array(
      '#markup' => $this->t('Hello, @person', array('@person'=>$person_name)),
    );
  }

  private function getBlockViewStyles() {
    $styles = [
      t('Slider Three Columns'),
      t('Two Columns'), 
      t('Three Columns'), 
    ];
  }

}
