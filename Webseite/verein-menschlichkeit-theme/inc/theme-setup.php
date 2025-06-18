<?php
// Theme Setup und grundlegende Supports
function verein_menschlichkeit_setup() {
  add_theme_support('title-tag');
  add_theme_support('custom-logo');
  add_theme_support('post-thumbnails');
  add_theme_support('editor-styles');
  add_editor_style('style.css');
  load_theme_textdomain('verein-menschlichkeit', get_template_directory() . '/languages');
  register_nav_menus([
    'main-menu' => __('Hauptmenü', 'verein-menschlichkeit')
  ]);
}
add_action('after_setup_theme', 'verein_menschlichkeit_setup');
