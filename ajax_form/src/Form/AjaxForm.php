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

        $form['checkbox_1'] = [
            '#type' => 'checkbox',
            '#title' => 'Checkbox #1',
            '#ajax' => [
                'callback' => '::textFieldsAjax',
                'event' => 'change',
            ]
        ];

        $form['checkbox_2'] = [
            '#type' => 'checkbox',
            '#title' => 'Checkbox #2',
            '#ajax' => [
                'callback' => '::linkAjax',
                'event' => 'change',
            ]
        ];

        $form['ajax_field'] = [
            '#type' => 'container',
            '#attributes' => [
                'class' => 'ajax_field',
                'style' => 'display:none',
            ]
        ];

        $form['ajax_field']['text_field_1'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Textfield #1'),
        ];

        $form['ajax_field']['text_field_2'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Textfield #2'),
        ];

        $form['actionss']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        ];

        $form['ajax_link'] = [
            '#type' => 'container',
            '#attributes' => [
                'class' => 'ajax_link'
            ]
        ];

        return $form;
    }

    public function textFieldsAjax(array &$form, FormStateInterface $form_state) {
        $response = new AjaxResponse();
        if ($form_state->getValue('checkbox_1') === 1) {
            $response->addCommand(new CssCommand('.ajax_field', ['display' => 'block']));
        }
        else {
            $response->addCommand(new CssCommand('.ajax_field', ['display' => 'none']));
        }
        return $response;
    }

    public function linkAjax(array &$form, FormStateInterface $form_state) {
        $response = new AjaxResponse();
        $selector = '.ajax_link';
        // Hide or show link.
        if ($form_state->getValue('checkbox_2') === 1) {
            $data = '<a href="https://www.google.com/">Google link</a>';
        }
        else {
            $data = '';
        }
        $response->addCommand(new HtmlCommand($selector, $data));
        return $response;
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