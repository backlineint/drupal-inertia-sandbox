<?php

declare(strict_types=1);

namespace Drupal\inertia;

class Inertia {
  static function render(string $component, array $props = [], string $url = '', string $version = '') {
    $data_page = [
      'component' => $component,
      'props' => $props,
      'url' => $url,
      'version' => $version,
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