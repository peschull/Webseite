<?php
/**
 * Block Name: Statistikblock animiert
 * Description: Animierte Statistiken und Zahlen
 * Category: menschlichkeit
 * Icon: chart-pie
 * Keywords: statistik, zahlen, animiert
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_statistikblock_animiert() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'statistikblock-animiert',
            'title'             => __('Statistikblock animiert', 'menschlichkeit'),
            'description'       => __('Animierte Statistiken und Zahlen', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'chart-pie',
            'keywords'          => array('statistik', 'zahlen', 'animiert'),
            'render_template'   => 'blocks/statistikblock-animiert/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/statistikblock-animiert/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/statistikblock-animiert/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_statistikblock_animiert');
