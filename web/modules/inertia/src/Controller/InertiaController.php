<?php

declare(strict_types=1);

namespace Drupal\inertia\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\inertia\Inertia;

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

    return Inertia::render('example', [
      'node' => [
        'id' => $node->id(),
        'title' => $node->getTitle(),
        'description' => $node->get('body')->value,
      ],
    ], "/inertia/$path", 'c32b8e4965f418ad16eaebba1d4e960f');

    // return [
    //   '#theme' => 'inertia_example',
    //   //'#test_var' => $this->t('Test Value'),
    // ];
  }

}
