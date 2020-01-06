<?php

namespace Drupal\ax_json_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class JsonController.
 *
 * @package Drupal\ax_json_api\Controller
 */
class JsonController extends ControllerBase {

  /**
   * Returns JSON response of node data.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Request.
   * @param string $site_api_key
   *   Site API key from url.
   * @param int|null $nid
   *   Node Id from url.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Node data in the form of JSON.
   */
  public function content($site_api_key = NULL, $nid = NULL) {
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');
    $node = $node_storage->load($nid);

    $serializer = \Drupal::service('serializer');
    $data = $serializer->serialize($node, 'json');

    return new JsonResponse($data);
  }

}
