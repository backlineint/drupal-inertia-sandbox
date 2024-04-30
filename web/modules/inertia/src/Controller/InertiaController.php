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
      '#markup' => '<div id="app" data-page=\'{"component":"example","props":{"event":{"id":80,"title":"Birthday party","start_date":"2019-06-02","description":"Come out and celebrate Jonathan&apos;s 36th birthday party!"}},"url":"/events/80","version":"c32b8e4965f418ad16eaebba1d4e960f"}\'></div>
      ',
      '#attached' => array(
        'library' => array(
            'inertia/app',
        ),
    ),
    ];

    return $build;
  }

}
