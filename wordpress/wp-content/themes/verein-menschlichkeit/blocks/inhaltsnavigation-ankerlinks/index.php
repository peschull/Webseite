<?php
/**
 * Block Name: Inhaltsnavigation-Ankerlinks
 * Description: Eine automatische Navigation mit Ankerlinks zu Inhaltsbereichen
 * Category: menschlichkeit
 * Icon: menu
 * Keywords: [navigation, anker, inhaltsverzeichnis, toc]
 * 
 * @package Verein-Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Block Registrierung.
 */
function register_inhaltsnavigation_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'inhaltsnavigation-ankerlinks',
            'title'            => __('Inhaltsnavigation mit Ankerlinks', 'verein-menschlichkeit'),
            'description'      => __('Eine automatische Navigation mit Ankerlinks zu Inhaltsbereichen', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'menu',
            'keywords'         => array('navigation', 'anker', 'inhaltsverzeichnis', 'toc'),
            'render_template'  => 'blocks/inhaltsnavigation-ankerlinks/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/inhaltsnavigation-ankerlinks/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/inhaltsnavigation-ankerlinks/script.js',
            'supports'         => array(
                'align' => true,
                'mode' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_inhaltsnavigation_block');
