<?php

namespace Drupal\ax_json_api\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Symfony\Component\Routing\Route;

/**
 * Class CustomAccessCheck.
 *
 * @package Drupal\ax_json_api\Access
 */
class CustomAccessCheck implements AccessInterface {

  /**
   * Access conditions for JSON endpoint.
   *
   * @param \Symfony\Component\Routing\Route $route
   *   Route of json endpoint.
   * @param string $site_api_key
   *   API key from url.
   * @param int $nid
   *   Node id from url.
   *
   * @return \Drupal\Core\Access\AccessResultAllowed|\Drupal\Core\Access\AccessResultForbidden
   *   Returns access value.
   */
  public function access(Route $route, $site_api_key, $nid) {
    // Get site API key for verification.
    $siteapikey = \Drupal::config('system.site')->get('siteapikey', '');
    // Node object.
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');
    $node = $node_storage->load($nid);

    if ($node) {
      // Check the node type is page and site api is present.
      if ($site_api_key == $siteapikey && $node->getType() == 'page') {
        return AccessResult::allowed();
      }
    }
    return AccessResult::forbidden();
  }

}
