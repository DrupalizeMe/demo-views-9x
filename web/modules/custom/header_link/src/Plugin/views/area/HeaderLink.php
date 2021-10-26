<?php
namespace Drupal\header_link\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Views area link handler.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("header_link")
 */
class HeaderLink extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['link_text']['default'] = 'Back >';
    $options['link_url']['default'] = '';
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $form['link_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link text'),
      '#size' => 60,
      '#default_value' => $this->options['link_text'],
      '#maxlength' => 128,
    ];
    $form['link_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link URL'),
      '#default_value' => $this->options['link_url'],
      '#size' => 60,
      '#maxlength' => 128,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if ((!$empty || !empty($this->options['empty'])) && !empty($this->options['link_url'])) {
      $items = [];
      if (!empty($this->options['link_text'])) {
        $text = $this->t($this->options['link_text']);
      }
      else {
        $text = $this->t('Back >');
      }
      if (strpos($this->options['link_url'], 'http') !== FALSE) {
        $url = Url::fromUri($this->options['link_url']);
      }
      elseif (isset($url_opt) && strpos($url_opt, '/') === 0) {
        $url = Url::fromUserInput($this->options['link_url']);
      }
      else {
        $url = Url::fromUserInput('/' . $this->options['link_url']);
      }
      $item = [
        '#type' => 'link',
        '#title' => $text,
        '#url' => $url,
      ];
      return [
        '#markup' => \Drupal::service('renderer')->render($item),
      ];
    }
  }
}
