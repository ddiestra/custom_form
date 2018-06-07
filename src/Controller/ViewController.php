<?php

namespace Drupal\custom_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Drupal;


/**
 * ViewController.
 */
class ViewController extends ControllerBase {

  /**
   * Display the page information or a 403 page.
   */
  public function view($apikey, $nid) {

    $config = $this->config('custom_form.settings');

    if ($config->get('siteapikey') == $apikey) {

      $node = Node::load($nid);

      if ($node && $node->getType() == 'page') {
        $data = [
          'nid' => $node->ID(),
          'title' => $node->getTitle(),
          'body' => $node->get('body')->getValue(),
        ];
        return new JsonResponse(['node' => $data]);
      }


    }

    throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
  }

}
