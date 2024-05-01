<?php

declare(strict_types=1);

namespace Drupal\inertia\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Returns responses for Inertia routes.
 */
final class InertiaController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke($path): array {
    $new_path = \Drupal::service('path_alias.manager')->getPathByAlias("/$path");

    if(preg_match('/node\/(\d+)/', $new_path, $matches)) {
      $node = \Drupal\node\Entity\Node::load($matches[1]);
    }
    else {
      throw new NotFoundHttpException();
    }

    // Next - abstract constructing this and the build array to a set of helpers
    $data_page = [
      'component' => 'example',
      'props' => [
        'event' => [
          'id' => $node->id(),
          'title' => $node->getTitle(),
          // Todo - test with HTML
          'description' => $node->get('body')->value,
        ],
        // TODO - fix URL redirect
        'url' => "/inertia/$path",
        'version' => 'c32b8e4965f418ad16eaebba1d4e960f',
      ],
    ];

    $build['content'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#attributes' => ['id' => 'app', 'data-page' => json_encode($data_page)],
      '#attached' => array(
        'library' => array(
            'inertia/app',
        ),
      ),
    ];

    return $build;
  }

}
