<?php

declare(strict_types=1);

namespace Drupal\inertia;

class Inertia {
  // Should this accept context / &$variables as well?
  static function render(string $component, array $props = [], string $url = '', string $version = '', array $slots = []) {
    $data_page = [
      'component' => $component,
      'props' => $props,
      'url' => $url,
      'version' => $version,
    ];

    // TODO - handle ID overrides
    // TODO - handle library overrides
    $build['content'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'app', 'data-page' => json_encode($data_page)],
      // '#attached' => array(
      //   'library' => array(
      //       // TODO - allow this method to accept a library override
      //       'inertia/app',
      //   ),
      // ),
    ];

    foreach ($slots as $slot_name => $slot_content) {
      $build['content'][$slot_name] = [
        '#type' => 'html_tag',
        '#tag' => 'template',
        // TODO - ID needs to be more specific
        '#attributes' => ['name' => $slot_name],
        '#value' => $slot_content,
      ];
    }

    return $build;
  }

  // Should this accept overrides for component, props, etc.?
  // Also accept options array? Only option restricts fields displayed for example.
  // $example_options = [
  //   'library' => [],
  // ];
  static function renderByContext(&$variables, $options = []) {
    $props = [];
    $slots = [];
    $prop_keys = array_keys($variables['content']);
    foreach ($prop_keys as $key) {
      // TODO - cases for SDCs, entities, etc.
      if ($variables['node']->hasField($key)) {
        $field = $variables['node']->get($key);
        $render_array = $field->view($variables['view_mode']);
        $rendered = \Drupal::service('renderer')->render($render_array);
        $props['props'][$key] = 'slot:' . $key;
        $slots[$key] = $rendered;
      }
    }

    // TODO - think more about the best way to handle template suggestions
    $variables['content'] = self::render(
      $variables['theme_hook_original'] . '--' . $variables['node']->getType() . '--' . $variables['view_mode'],
      $props,
      $variables['url'],
      '',
      $slots
    )['content'];
  }
}