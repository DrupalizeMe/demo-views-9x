<?php

namespace Drupal\news\Plugin\views\field;

use Drupal\views\Plugin\views\field\Date;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\ResultRow;


/**
 * A handler to provide custom displays for subscription dates.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("subscribed_views_field")
 */
class SubscribedViewsField extends Date {


  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $form['date_format']['#options']['subscribed for'] = $this->t('Time span (with "Subscribed for" prepended)');
    $form['custom_date_format']['#states']['visible'][] = [
      ':input[name="options[date_format]"]' => ['value' => 'subscribed for'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $value = $this->getValue($values);
    $format = $this->options['date_format'];
    if ($format == 'subscribed for') {
      $custom_format = $this->options['custom_date_format'];
      if ($value) {
        $timezone = !empty($this->options['timezone']) ? $this->options['timezone'] : NULL;
        // Will be positive for a datetime in the past (ago), and negative for a
        // datetime in the future (hence).
        $request_time = \Drupal::time()->getRequestTime();
        $time_diff = $request_time - $value;
        $time = $this->dateFormatter->formatTimeDiffSince($value, ['strict' => FALSE, 'granularity' => is_numeric($custom_format) ? $custom_format : 2]);
        return $this->t('Subscribed for %time', ['%time' => $time]);
      }
    }
    return parent::render($values);
  }

}
