<?php

declare(strict_types=1);

namespace Drupal\inertia;

class Inertia {
  // TODO - Maybe accept 'variables' array passed by reference here?
  static function render(string $component, array $props = [], string $url = '', string $version = '') {
    // TODO - can we automatically determine the template based on suggestions?
    // TODO - automatically determine the URL if not provided
    // TODO - some magic for versioning
    $data_page = [
      'component' => $component,
      'props' => $props,
      'url' => $url,
      'version' => $version,
    ];

    // TODO - handle ID overrides
    // TODO - handle library overrides
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

  // Render by context method - does everything automatically based on pass by reference $variable being passed?
  // static function renderByContext(&$variables) {
  // Handles both nodes and SDCs.
}