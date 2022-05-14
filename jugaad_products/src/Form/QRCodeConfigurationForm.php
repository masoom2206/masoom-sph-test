<?php

namespace Drupal\jugaad_products\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures QR code settings.
 */
class QRCodeConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'jugaad_products_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('jugaad_products.settings');
    $form['image_size'] = [
      '#type' => 'range',
      '#title' => $this->t('QR Image Size'),
      '#default_value' => $config->get('image_size'),
      '#min' => 100,
      '#max' => 1000,
      '#step' => 100,
    ];
    $form['image_margin'] = [
      '#type' => 'range',
      '#title' => $this->t('QR Image Margin'),
      '#default_value' => $config->get('image_margin'),
      '#min' => 0,
      '#max' => 200,
      '#step' => 5,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('jugaad_products.settings')
      ->set('image_size', (int) $values['image_size'])
      ->set('image_margin', (int) $values['image_margin'])
      ->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'jugaad_products.settings',
    ];
  }

}
