<?php
/**
 * Block Name: Unsere Werte Block
 * Description: Ein Block zur Darstellung der Vereinswerte mit Icons und Beschreibungen
 * Category: content
 * Icon: heart
 * Keywords: werte, mission, vision, grundsätze
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Register Block
if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
        'name'              => 'unsere-werte-block',
        'title'             => __('Unsere Werte Block'),
        'description'       => __('Ein Block zur Darstellung der Vereinswerte mit Icons und Beschreibungen'),
        'render_template'   => 'blocks/unsere-werte-block/template.php',
        'category'          => 'content',
        'icon'              => 'heart',
        'keywords'          => array('werte', 'mission', 'vision', 'grundsätze'),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/unsere-werte-block/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/unsere-werte-block/script.js',
        'mode'              => 'edit',
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true
        )
    ));
}
