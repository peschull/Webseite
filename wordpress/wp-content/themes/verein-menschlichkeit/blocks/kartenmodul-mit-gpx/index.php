<?php
/**
 * Block Name: Kartenmodul mit GPX
 * Description: Zeigt eine Karte mit GPX-Track und optionalen Markern
 * Category: menschlichkeit
 * Icon: location-alt
 * Keywords: karte, gpx, route, track
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_kartenmodul_mit_gpx() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'kartenmodul-mit-gpx',
            'title'             => __('Kartenmodul mit GPX', 'menschlichkeit'),
            'description'       => __('Zeigt eine Karte mit GPX-Track und optionalen Markern', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'location-alt',
            'keywords'          => array('karte', 'gpx', 'route', 'track'),
            'render_template'   => 'blocks/kartenmodul-mit-gpx/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/kartenmodul-mit-gpx/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/kartenmodul-mit-gpx/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_kartenmodul_mit_gpx');
