<?php
/**
 * Block Name: Parallax-Header
 * Description: Ein Header-Bereich mit Parallax-Scrolling-Effekt
 * Category: menschlichkeit
 * Icon: cover-image
 * Keywords: [header, parallax, bild, titel]
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
function register_parallax_header_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'parallax-header',
            'title'            => __('Parallax-Header', 'verein-menschlichkeit'),
            'description'      => __('Ein Header-Bereich mit Parallax-Scrolling-Effekt', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'cover-image',
            'keywords'         => array('header', 'parallax', 'bild', 'titel'),
            'render_template'  => 'blocks/parallax-header/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/parallax-header/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/parallax-header/script.js',
            'supports'         => array(
                'align' => array('full', 'wide'),
                'mode' => true,
                'jsx' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_parallax_header_block');
