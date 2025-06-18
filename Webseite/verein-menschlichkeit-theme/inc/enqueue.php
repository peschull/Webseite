<?php
// Scripte und Styles laden
function verein_menschlichkeit_enqueue_scripts() {
  if (!is_admin()) {
    wp_enqueue_style('verein-style', get_stylesheet_uri(), [], null);
    wp_enqueue_style('verein-fonts', get_template_directory_uri() . '/fonts/fonts.css', [], null);
  }
}
add_action('wp_enqueue_scripts', 'verein_menschlichkeit_enqueue_scripts', 11);
