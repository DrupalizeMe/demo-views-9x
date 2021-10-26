<?php

namespace Drupal\subscriber\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\subscriber\SubscriberInterface;

/**
 * Defines the subscriber entity class.
 *
 * @ContentEntityType(
 *   id = "subscriber",
 *   label = @Translation("Subscriber"),
 *   label_singular = @Translation("Subscriber"),
 *   label_plural = @Translation("Subscribers"),
 *   label_collection = @Translation("Subscribers"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\subscriber\SubscriberListBuilder",
 *     "views_data" = "\Drupal\subscriber\SubscriberViewsData",
 *     "form" = {
 *       "add" = "Drupal\subscriber\Form\SubscriberForm",
 *       "edit" = "Drupal\subscriber\Form\SubscriberForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "subscriber",
 *   admin_permission = "administer subscriber",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/content/subscriber/add",
 *     "canonical" = "/subscriber/{subscriber}",
 *     "edit-form" = "/admin/content/subscriber/{subscriber}/edit",
 *     "delete-form" = "/admin/content/subscriber/{subscriber}/delete",
 *     "collection" = "/admin/content/subscriber"
 *   },
 *   field_ui_base_route = "entity.subscriber.settings"
 * )
 */
class Subscriber extends ContentEntityBase implements SubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('The email of the subscriber.'))
      ->setDefaultValue('')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE)
      ->addConstraint('UserMailRequired')
      ->addConstraint('UserMailUnique');

    return $fields;
  }

}
