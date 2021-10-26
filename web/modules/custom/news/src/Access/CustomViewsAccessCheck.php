<?php

namespace Drupal\news\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Checks access for display news page for residential editors
 */
class CustomViewsAccessCheck implements AccessInterface {

  /**
   * A custom access check.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account) {
    // Skip access check for User 1.
    if ($account->id() == 1) {
      return AccessResult::allowed();
    }
    // Load user entity.
    $user = \Drupal::entityTypeManager()->getStorage('user')->load($account->id());
    if (isset($user->field_resident_editor) && $user->field_resident_editor->value) {
      return AccessResult::allowed();
    }
    else {
      return AccessResult::forbidden();
    }
  }

}
