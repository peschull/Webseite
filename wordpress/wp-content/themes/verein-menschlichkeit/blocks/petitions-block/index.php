<?php
/**
 * Block Name: Petitions-Block
 * Description: Ein Block zum Anzeigen und Verwalten von Petitionen
 * Category: menschlichkeit
 * Icon: format-aside
 * Keywords: [petition, unterschrift, kampagne]
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
function register_petitions_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'petitions-block',
            'title'            => __('Petitions-Block', 'verein-menschlichkeit'),
            'description'      => __('Ein Block zum Anzeigen und Verwalten von Petitionen', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'format-aside',
            'keywords'         => array('petition', 'unterschrift', 'kampagne'),
            'render_template'  => 'blocks/petitions-block/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/petitions-block/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/petitions-block/script.js',
            'supports'         => array(
                'align' => true,
                'mode' => true,
                'jsx' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_petitions_block');
