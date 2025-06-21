<?php
/**
 * Block Name: Projekt-Scroller
 * Description: Horizontale Scroll-Liste für Projekte
 * Category: menschlichkeit
 * Icon: images-alt2
 * Keywords: projekt, scroller, horizontal, slider
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_projekt_scroller() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'projekt-scroller',
            'title'             => __('Projekt-Scroller', 'menschlichkeit'),
            'description'       => __('Horizontale Scroll-Liste für Projekte', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'images-alt2',
            'keywords'          => array('projekt', 'scroller', 'horizontal', 'slider'),
            'render_template'   => 'blocks/projekt-scroller/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/projekt-scroller/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/projekt-scroller/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_projekt_scroller');
