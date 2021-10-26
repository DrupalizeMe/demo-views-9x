<?php

namespace Drupal\subscriber\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the subscriber entity edit forms.
 */
class SubscriberForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New subscriber %label has been created.', $message_arguments));
      $this->logger('subscriber')->notice('Created new subscriber %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The subscriber %label has been updated.', $message_arguments));
      $this->logger('subscriber')->notice('Updated new subscriber %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.subscriber.canonical', ['subscriber' => $entity->id()]);
  }

}
