<?php
/**
 * @file
 */

namespace Drupal\subscriber;

use Drupal\views\EntityViewsData;

class SubscriberViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['subscriber']['email']['relationship'] = [
      'base' => 'users_field_data',
      'base field' => 'mail',
      // ID of relationship handler plugin to use.
      'id' => 'standard',
      // Default label for relationship in the UI.
      'label' => $this->t('Related users'),
    ];

    return $data;
  }

}
