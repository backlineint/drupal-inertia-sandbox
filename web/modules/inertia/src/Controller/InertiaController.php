<?php

declare(strict_types=1);

namespace Drupal\inertia\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Inertia routes.
 */
final class InertiaController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
