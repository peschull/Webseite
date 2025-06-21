<?php
// Custom Post Types für Team, Veranstaltungen, Downloads, Testimonials
function verein_register_team_cpt() {
  register_post_type('team', [
    'labels' => [
      'name' => __('Team', 'verein-menschlichkeit'),
      'singular_name' => __('Teammitglied', 'verein-menschlichkeit')
    ],
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-groups',
    'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
    'rewrite' => ['slug' => 'team'],
  ]);
}
function verein_register_event_cpt() {
  register_post_type('event', [
    'labels' => [
      'name' => __('Veranstaltungen', 'verein-menschlichkeit'),
      'singular_name' => __('Veranstaltung', 'verein-menschlichkeit')
    ],
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-calendar-alt',
    'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
    'rewrite' => ['slug' => 'veranstaltungen'],
  ]);
}
function verein_register_download_cpt() {
  register_post_type('download', [
    'labels' => [
      'name' => __('Downloads', 'verein-menschlichkeit'),
      'singular_name' => __('Download', 'verein-menschlichkeit')
    ],
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-download',
    'supports' => ['title', 'editor', 'custom-fields'],
    'rewrite' => ['slug' => 'downloads'],
  ]);
}
function verein_register_testimonial_cpt() {
  register_post_type('testimonial', [
    'labels' => [
      'name' => __('Testimonials', 'verein-menschlichkeit'),
      'singular_name' => __('Testimonial', 'verein-menschlichkeit')
    ],
    'public' => true,
    'has_archive' => false,
    'menu_icon' => 'dashicons-format-quote',
    'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
    'rewrite' => ['slug' => 'testimonials'],
  ]);
}
add_action('init', 'verein_register_team_cpt');
add_action('init', 'verein_register_event_cpt');
add_action('init', 'verein_register_download_cpt');
add_action('init', 'verein_register_testimonial_cpt');
