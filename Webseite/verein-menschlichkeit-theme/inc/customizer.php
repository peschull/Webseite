<?php
// Customizer Einstellungen für Farben und Social Media
function verein_menschlichkeit_customize_register($wp_customize) {
  $wp_customize->add_section('verein_colors', [
    'title'    => __('Farben', 'verein-menschlichkeit'),
    'priority' => 30,
  ]);
  $wp_customize->add_setting('verein_primary_color', [
    'default'   => '#2563eb',
    'transport' => 'refresh',
    'sanitize_callback' => 'sanitize_hex_color',
  ]);
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'verein_primary_color', [
    'label'    => __('Primärfarbe', 'verein-menschlichkeit'),
    'section'  => 'verein_colors',
    'settings' => 'verein_primary_color',
  ]));
  $wp_customize->add_section('verein_social', [
    'title'    => __('Social Media', 'verein-menschlichkeit'),
    'priority' => 40,
  ]);
  $wp_customize->add_setting('verein_facebook', ['default' => '', 'sanitize_callback' => 'esc_url']);
  $wp_customize->add_control('verein_facebook', [
    'label'   => __('Facebook URL', 'verein-menschlichkeit'),
    'section' => 'verein_social',
    'type'    => 'url',
  ]);
  $wp_customize->add_setting('verein_instagram', ['default' => '', 'sanitize_callback' => 'esc_url']);
  $wp_customize->add_control('verein_instagram', [
    'label'   => __('Instagram URL', 'verein-menschlichkeit'),
    'section' => 'verein_social',
    'type'    => 'url',
  ]);
}
add_action('customize_register', 'verein_menschlichkeit_customize_register');
