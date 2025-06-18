<?php
/**
 * Block Name: Zitatschleife mit Carousel
 * Description: Ein Carousel zur Anzeige von Zitaten in einer kontinuierlichen Schleife
 * Category: content
 * Icon: format-quote
 * Keywords: zitate, carousel, slider, testimonials
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Register Block
if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
        'name'              => 'zitatschleife-mit-carousel',
        'title'             => __('Zitatschleife mit Carousel'),
        'description'       => __('Ein Carousel zur Anzeige von Zitaten in einer kontinuierlichen Schleife'),
        'render_template'   => 'blocks/zitatschleife-mit-carousel/template.php',
        'category'          => 'content',
        'icon'              => 'format-quote',
        'keywords'          => array('zitate', 'carousel', 'slider', 'testimonials'),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/zitatschleife-mit-carousel/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/zitatschleife-mit-carousel/script.js',
        'mode'              => 'edit',
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true
        )
    ));
}
