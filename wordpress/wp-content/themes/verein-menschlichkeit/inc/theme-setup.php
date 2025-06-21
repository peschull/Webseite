<?php
/**
 * Theme Setup und grundlegende Funktionalität
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function verein_menschlichkeit_setup() {
    // Core Theme Supports
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style'
    ]);
    
    // Editor Unterstützung
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_editor_style('style.css');
    
    // Gutenberg Editor Farbpalette
    add_theme_support('editor-color-palette', [
        [
            'name'  => __('Primärfarbe', 'verein-menschlichkeit'),
            'slug'  => 'primary',
            'color' => '#2563eb',
        ],
        [
            'name'  => __('Sekundärfarbe', 'verein-menschlichkeit'),
            'slug'  => 'secondary',
            'color' => '#dc2626',
        ],
        [
            'name'  => __('Weiß', 'verein-menschlichkeit'),
            'slug'  => 'white',
            'color' => '#ffffff',
        ],
        [
            'name'  => __('Schwarz', 'verein-menschlichkeit'),
            'slug'  => 'black',
            'color' => '#000000',
        ],
        [
            'name'  => __('Grau Hell', 'verein-menschlichkeit'),
            'slug'  => 'gray-light',
            'color' => '#f3f4f6',
        ],
        [
            'name'  => __('Grau Dunkel', 'verein-menschlichkeit'),
            'slug'  => 'gray-dark',
            'color' => '#374151',
        ],
    ]);
    
    // Custom Logo Größe
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    
    // Textdomain laden
    load_theme_textdomain('verein-menschlichkeit', get_template_directory() . '/languages');
    
    // Menüs registrieren
    register_nav_menus([
        'main-menu' => __('Hauptmenü', 'verein-menschlichkeit'),
        'footer-menu' => __('Footer-Menü', 'verein-menschlichkeit'),
        'mobile-menu' => __('Mobile-Menü', 'verein-menschlichkeit')
    ]);
    
    // Bildgrößen definieren
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('card-image', 400, 300, true);
    add_image_size('gallery-thumb', 300, 300, true);
    add_image_size('team-image', 350, 350, true);
    
    // Feed Links
    add_theme_support('automatic-feed-links');
    
    // Content Width
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'verein_menschlichkeit_setup');

/**
 * Widget-Bereiche registrieren
 */
function verein_menschlichkeit_widgets_init() {
    register_sidebar([
        'name'          => __('Footer Widget 1', 'verein-menschlichkeit'),
        'id'            => 'footer-1',
        'description'   => __('Erscheint im Footer-Bereich', 'verein-menschlichkeit'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    
    register_sidebar([
        'name'          => __('Footer Widget 2', 'verein-menschlichkeit'),
        'id'            => 'footer-2',
        'description'   => __('Erscheint im Footer-Bereich', 'verein-menschlichkeit'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    
    register_sidebar([
        'name'          => __('Footer Widget 3', 'verein-menschlichkeit'),
        'id'            => 'footer-3',
        'description'   => __('Erscheint im Footer-Bereich', 'verein-menschlichkeit'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    
    register_sidebar([
        'name'          => __('Sidebar', 'verein-menschlichkeit'),
        'id'            => 'sidebar-1',
        'description'   => __('Erscheint in der Seitenleiste', 'verein-menschlichkeit'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'verein_menschlichkeit_widgets_init');
