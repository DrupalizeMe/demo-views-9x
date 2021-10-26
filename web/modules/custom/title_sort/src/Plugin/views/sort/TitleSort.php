<?php

namespace Drupal\title_sort\Plugin\views\sort;

use Drupal\views\Plugin\views\sort\SortPluginBase;

/**
 * Basic sort handler for Titles without articles.
 *
 * @ViewsSort("natural_title_sort")
 */
class TitleSort extends SortPluginBase {

  /**
   * Called to add the sort to a query.
   */
  public function query() {
    $this->ensureMyTable();

    $this->query->addField(
      NULL,
      "TRIM(LEADING 'a ' FROM TRIM(LEADING 'an ' FROM TRIM( LEADING 'the ' FROM LOWER($this->realField))))",
      'natural_sort'
    );

    $this->query->addOrderBy(NULL, NULL, $this->options['order'], 'natural_sort');
  }
}
