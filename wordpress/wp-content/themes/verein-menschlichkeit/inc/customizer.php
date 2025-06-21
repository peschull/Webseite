<?php
/**
 * WordPress Customizer Einstellungen
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer Einstellungen hinzufügen
 */
function verein_menschlichkeit_customize_register($wp_customize) {
    
    // Theme Optionen Panel
    $wp_customize->add_panel('verein_theme_options', [
        'title' => __('Theme Optionen', 'verein-menschlichkeit'),
        'description' => __('Allgemeine Theme Einstellungen', 'verein-menschlichkeit'),
        'priority' => 30,
    ]);
    
    // ===== FARBEN SEKTION =====
    $wp_customize->add_section('verein_colors', [
        'title' => __('Farben', 'verein-menschlichkeit'),
        'panel' => 'verein_theme_options',
        'priority' => 20,
    ]);
    
    // Primärfarbe
    $wp_customize->add_setting('verein_primary_color', [
        'default' => '#2563eb',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'verein_primary_color', [
        'label' => __('Primärfarbe', 'verein-menschlichkeit'),
        'section' => 'verein_colors',
        'settings' => 'verein_primary_color',
        'description' => __('Hauptfarbe für Buttons, Links und Akzente', 'verein-menschlichkeit'),
    ]));
    
    // Sekundärfarbe
    $wp_customize->add_setting('verein_secondary_color', [
        'default' => '#dc2626',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'verein_secondary_color', [
        'label' => __('Sekundärfarbe', 'verein-menschlichkeit'),
        'section' => 'verein_colors',
        'description' => __('Zweite Akzentfarbe', 'verein-menschlichkeit'),
    ]));
    
    // ===== SOCIAL MEDIA SEKTION =====
    $wp_customize->add_section('verein_social', [
        'title' => __('Social Media', 'verein-menschlichkeit'),
        'panel' => 'verein_theme_options',
        'priority' => 40,
    ]);
    
    // Facebook
    $wp_customize->add_setting('verein_facebook', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('verein_facebook', [
        'label' => __('Facebook URL', 'verein-menschlichkeit'),
        'section' => 'verein_social',
        'type' => 'url',
    ]);
    
    // Instagram
    $wp_customize->add_setting('verein_instagram', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('verein_instagram', [
        'label' => __('Instagram URL', 'verein-menschlichkeit'),
        'section' => 'verein_social',
        'type' => 'url',
    ]);
    
    // Twitter
    $wp_customize->add_setting('verein_twitter', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('verein_twitter', [
        'label' => __('Twitter URL', 'verein-menschlichkeit'),
        'section' => 'verein_social',
        'type' => 'url',
    ]);
    
    // LinkedIn
    $wp_customize->add_setting('verein_linkedin', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('verein_linkedin', [
        'label' => __('LinkedIn URL', 'verein-menschlichkeit'),
        'section' => 'verein_social',
        'type' => 'url',
    ]);
    
    // YouTube
    $wp_customize->add_setting('verein_youtube', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    
    $wp_customize->add_control('verein_youtube', [
        'label' => __('YouTube URL', 'verein-menschlichkeit'),
        'section' => 'verein_social',
        'type' => 'url',
    ]);
    
    // ===== FOOTER SEKTION =====
    $wp_customize->add_section('verein_footer', [
        'title' => __('Footer', 'verein-menschlichkeit'),
        'panel' => 'verein_theme_options',
        'priority' => 50,
    ]);
    
    // Footer Text
    $wp_customize->add_setting('verein_footer_text', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    
    $wp_customize->add_control('verein_footer_text', [
        'label' => __('Footer Text', 'verein-menschlichkeit'),
        'section' => 'verein_footer',
        'type' => 'textarea',
        'description' => __('Text der im Footer angezeigt wird', 'verein-menschlichkeit'),
    ]);
    
    // Footer Copyright
    $wp_customize->add_setting('verein_footer_copyright', [
        'default' => sprintf('© %s %s', date('Y'), get_bloginfo('name')),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('verein_footer_copyright', [
        'label' => __('Copyright Text', 'verein-menschlichkeit'),
        'section' => 'verein_footer',
        'type' => 'text',
    ]);
}
add_action('customize_register', 'verein_menschlichkeit_customize_register');

/**
 * CSS für Customizer Einstellungen generieren
 */
function verein_menschlichkeit_customizer_css() {
    $primary_color = get_theme_mod('verein_primary_color', '#2563eb');
    $secondary_color = get_theme_mod('verein_secondary_color', '#dc2626');
    
    $css = "
        :root {
            --color-primary: {$primary_color};
            --color-secondary: {$secondary_color};
        }
        
        .btn-primary {
            background-color: {$primary_color};
            border-color: {$primary_color};
        }
        
        .btn-secondary {
            background-color: {$secondary_color};
            border-color: {$secondary_color};
        }
        
        a {
            color: {$primary_color};
        }
        
        a:hover {
            color: {$secondary_color};
        }
        
        .text-primary {
            color: {$primary_color} !important;
        }
        
        .text-secondary {
            color: {$secondary_color} !important;
        }
        
        .bg-primary {
            background-color: {$primary_color} !important;
        }
        
        .bg-secondary {
            background-color: {$secondary_color} !important;
        }
        
        .border-primary {
            border-color: {$primary_color} !important;
        }
        
        .border-secondary {
            border-color: {$secondary_color} !important;
        }
    ";
    
    return $css;
}

/**
 * Customizer CSS in Head einbinden
 */
function verein_menschlichkeit_customizer_head_css() {
    $css = verein_menschlichkeit_customizer_css();
    if ($css) {
        echo '<style type="text/css" id="verein-customizer-css">' . wp_strip_all_tags($css) . '</style>';
    }
}
add_action('wp_head', 'verein_menschlichkeit_customizer_head_css');
