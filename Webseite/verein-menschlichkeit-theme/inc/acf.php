<?php
// ACF Local JSON aktivieren und Guard für get_field einbauen
add_filter('acf/settings/save_json', function($path) {
  return get_template_directory() . '/acf-json';
});
add_filter('acf/settings/load_json', function($paths) {
  $paths[] = get_template_directory() . '/acf-json';
  return $paths;
});

// Helper: get_field nur nutzen, wenn ACF aktiv ist
function vmh_get_field($field, $post_id = false) {
  if (function_exists('get_field')) {
    return get_field($field, $post_id);
  }
  return '';
}
