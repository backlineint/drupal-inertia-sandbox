<?php

declare(strict_types=1);

namespace Drupal\inertia_examples\Controller;

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
  public function __invoke(): array {
    /**
     * A simple example of the Inertia render method.
     * This will mount the app using the example.tsx component in /app/src/pages
     * and pass the provided props.
     */
    $render =  Inertia::render('example', [
      'props' => [
        'heading' => 'Example Heading',
        'body' => 'Example Body',
      ],
    ], "/inertia/example", 'some_hash');
    $render['#attached']['library'][] =  'inertia_examples/app';
    return $render;
  }

}
