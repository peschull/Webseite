<?php
/**
 * Block Name: Verlinkte-Schlagworte
 * Description: Ein Block zur Anzeige und Verlinkung von Schlagworten/Tags
 * Category: menschlichkeit
 * Icon: tag
 * Keywords: [schlagworte, tags, keywords, verlinkung]
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
function register_verlinkte_schlagworte_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'verlinkte-schlagworte',
            'title'            => __('Verlinkte Schlagworte', 'verein-menschlichkeit'),
            'description'      => __('Ein Block zur Anzeige und Verlinkung von Schlagworten/Tags', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'tag',
            'keywords'         => array('schlagworte', 'tags', 'keywords', 'verlinkung'),
            'render_template'  => 'blocks/verlinkte-schlagworte/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/verlinkte-schlagworte/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/verlinkte-schlagworte/script.js',
            'supports'         => array(
                'align' => true,
                'mode' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_verlinkte_schlagworte_block');
