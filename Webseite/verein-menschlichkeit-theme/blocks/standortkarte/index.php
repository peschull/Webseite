<?php
/**
 * Block Name: Standortkarte
 * Description: Ein Block zur Anzeige einer interaktiven Standortkarte
 * Category: menschlichkeit
 * Icon: location
 * Keywords: [standort, karte, position]
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
function register_standortkarte_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'standortkarte',
            'title'            => __('Standortkarte', 'verein-menschlichkeit'),
            'description'      => __('Ein Block zur Anzeige einer interaktiven Standortkarte', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'location',
            'keywords'         => array('standort', 'karte', 'position'),
            'render_template'  => 'blocks/standortkarte/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/standortkarte/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/standortkarte/script.js',
            'supports'         => array(
                'align' => true,
                'mode' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_standortkarte_block');
