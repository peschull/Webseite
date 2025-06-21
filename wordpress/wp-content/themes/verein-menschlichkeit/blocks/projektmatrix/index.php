<?php
/**
 * Block Name: Projektmatrix
 * Description: Eine Matrix-Darstellung von Projekten mit Filteroptionen
 * Category: menschlichkeit
 * Icon: grid-view
 * Keywords: [projekt, matrix, übersicht, filter]
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
function register_projektmatrix_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'projektmatrix',
            'title'            => __('Projektmatrix', 'verein-menschlichkeit'),
            'description'      => __('Eine Matrix-Darstellung von Projekten mit Filteroptionen', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'grid-view',
            'keywords'         => array('projekt', 'matrix', 'übersicht', 'filter'),
            'render_template'  => 'blocks/projektmatrix/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/projektmatrix/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/projektmatrix/script.js',
            'supports'         => array(
                'align' => true,
                'mode' => true,
                'jsx' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_projektmatrix_block');
