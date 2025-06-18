<?php
/**
 * Block Name: Veranstaltungskalender mit Filter
 * Description: Zeigt einen filterbaren Kalender mit allen Veranstaltungen an
 * Category: menschlichkeit
 * Icon: calendar-alt
 * Keywords: veranstaltungen, kalender, filter, events
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Block-Registrierung
 */
function register_acf_block_veranstaltungskalender_mit_filter() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'veranstaltungskalender-mit-filter',
            'title'             => __('Veranstaltungskalender mit Filter', 'menschlichkeit'),
            'description'       => __('Zeigt einen filterbaren Kalender mit allen Veranstaltungen an', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'calendar-alt',
            'keywords'          => array('veranstaltungen', 'kalender', 'filter', 'events'),
            'render_template'   => 'blocks/veranstaltungskalender-mit-filter/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/veranstaltungskalender-mit-filter/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/veranstaltungskalender-mit-filter/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_veranstaltungskalender_mit_filter');
