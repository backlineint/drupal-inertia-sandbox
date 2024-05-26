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
            // TODO - either allow this function to accept a library, or
            // document how to override the default inertia app library
            'inertia_examples/app',
        ),
      ),
    ];

    return $build;
  }

  // Should this accept overrides for component, props, etc.?
  // Also accept options array? Only option restricts fields displayed for example.
  static function renderByContext(&$variables) {
    $props = [];
    $prop_keys = array_keys($variables['content']);
    $view_mode = $variables['view_mode'];
    $content_type = $variables['node']->getType();
    foreach ($prop_keys as $key) {
      // TODO - cases for SDCs, entities, etc.
      if ($variables['node']->hasField($key)) {
        $field = $variables['node']->get($key);
        $render_array = $field->view($view_mode);
        $rendered = \Drupal::service('renderer')->renderRoot($render_array);
        $props['node'][$key] = $rendered;
      }
    }

    $children = $variables['content'];
    // TODO - think more about the best way to handle template suggestions
    $variables['content'] = self::render(
      $variables['theme_hook_original'] . '--' . $content_type . '--' . $variables['view_mode'],
      $props,
      $variables['url'],
      ''
    )['content'];
    // Kind of a poor man's SSR here...
    $variables['content']['children'] = $children;
  }
}