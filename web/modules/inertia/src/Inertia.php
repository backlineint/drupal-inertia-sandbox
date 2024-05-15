<?php

declare(strict_types=1);

namespace Drupal\inertia;

class Inertia {
  // Should this accept context / &$variables as well?
  static function render(string $component, array $props = [], string $url = '', string $version = '') {
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

  // Should this accept overrides for component, props, etc.?
  // Also accept options array?
  static function renderByContext(&$variables) {
    $props = [];
    $prop_keys = array_keys($variables['content']);
    foreach ($prop_keys as $key) {
      // TODO - cases for SDCs, entities, etc.
      if ($variables['node']->hasField($key)) {
        $props['node'][$key] = $variables['node']->get($key)->value;
      }
    }

    // TODO - think more about the best way to handle template suggestions
    $variables['content'] = self::render(
      $variables['theme_hook_original'] . '--' . $variables['view_mode'],
      $props,
      $variables['url'],
      ''
    )['content'];
  }
}