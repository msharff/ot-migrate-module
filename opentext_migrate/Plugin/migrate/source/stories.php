<?php

namespace Drupal\opentext_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\MigrateException;
use Drupal\migrate_plus\Plugin\migrate\source\Url;
use Drupal\migrate\Row;

/**
 * Source plugin for D-H example story imports.
 *
 * @MigrateSource(
 *   id = "stories"
 * )
 */
class Stories extends Url {

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Take the multiple tags, grab their IDs, put them into a comma-delimited list,
    // and save them back for future processing on the destination.

    $channel_ids = array();
    $channels = $row->getSourceProperty('channel');
    foreach ($channels['data'] as $channel) {
      $channel_ids[] = $channel['id'];
    }
    $row->setSourceProperty('channel', implode(",", $channel_ids));

    if (is_null($row->getSourceProperty('pullquote'))) {
      $row->setSourceProperty('field_pullquote', array('value' => '', 'format' => 'minimal_html'));
    }

    if (is_null($row->getSourceProperty('blurb'))) {
      $row->setSourceProperty('field_cutline', array('value' => '', 'format' => 'minimal_html'));
    }

    if (is_null($row->getSourceProperty('image_caption'))) {
      $row->setSourceProperty('field_featured_image_caption', array('value' => '', 'format' => 'minimal_html'));
    }
  }
}