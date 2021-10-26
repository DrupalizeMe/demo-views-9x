<?php

namespace Drupal\news\Plugin\views\access;

use Drupal\views\Plugin\views\access\AccessPluginBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;

/**
 *
 * @ingroup views_access_plugins
 *
 * @ViewsAccess(
 *     id = "ResidentEditorAccess",
 *     title = @Translation("Custom access to views for resident editors"),
 *     help = @Translation("Check if user is an editor and also is marked as a resident in their account."),
 * )
 */
class ResidentEditorAccess extends AccessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function summaryTitle() {
    return $this->t('Custom Access Settings');
  }

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account) {
    $access = \Drupal::service('news.views_access')->access($account);
    if (isset($access) && $access->isAllowed()) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function alterRouteDefinition(Route $route){
    $route->setRequirement('_custom_access', 'news.views_access::access');
  }

}
