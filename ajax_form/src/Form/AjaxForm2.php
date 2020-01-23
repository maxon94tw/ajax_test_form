<?php

namespace Drupal\ajax_form\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class AjaxForm
 * @package Drupal\ajax_form\Form
 */

class AjaxForm extends FormBase {

    /**
     * @inheritDoc
     */
    public function getFormId() {
        return 'ajax_form';
    }

    /**
     * @inheritDoc
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['text_field'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Textfield')
        ];

        $form['field_set'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Fieldset checkbox'),
        ];

        $form['text_field_1'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Checkbox text field #1'),
            '#states' => [
                'invisible' => [
                    'input[name="field_set"]' => [
                        'checked' => FALSE,
                    ],
                ],
            ],
        ];

        $form['text_field_2'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Checkbox text field #2'),
            '#states' => [
                'invisible' => [
                    'input[name="field_set"]' => [
                        'checked' => FALSE,
                    ],
                ],
            ],
            '#ajax' => [
                'callback' => '::myAjaxCallback',
            ]
        ];

        $form['google_checkbox'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Checkbox with the url'),
        ];

        $form['google_url'] = [
            '#type' => 'link',
            '#title' => $this->t('Google link'),
            '#states' => [
                'invisible' => [
                    'input[name="google_checkbox"]' => [
                        'checked' => FALSE,
                    ],
                ],
            ],
            '#url' => Url::fromUri('http://google.com'),
        ];



        return $form;
    }


    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $text = $this->t('Ajaxed');
        \Drupal::messenger()->addMessage($text);
    }

}