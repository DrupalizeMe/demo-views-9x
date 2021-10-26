<?php

namespace Drupal\recipe\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Field handler to flag the node type.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("full_time")
 */
class FullTime extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid the field being used in the query.
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    $node = $values->_entity;
    if ($node->bundle() !== 'recipe') {
      return '';
    }
    $cook_time = $node->field_cook_time->value;
    $prep_time = $node->field_prep_time->value;

    $full_time = $cook_time + $prep_time;
    $full_time_h = floor($full_time / 60);
    $full_time_m = $full_time - $full_time_h * 60;

    return $this->t('Full cooking and preparation time @h h, @m min', ['@h' => $full_time_h, '@m' => $full_time_m]);
  }
}
