<?php
/**
 * Block Name: Hero Section mit Call-to-Action Scroll Trigger
 * Description: Eine Hero-Section mit einem Call-to-Action-Button, der beim Scrollen animiert wird
 * Category: layout
 * Icon: cover-image
 * Keywords: hero, cta, scroll, animation
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Register Block
if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
        'name'              => 'hero-section-mit-call-to-action-scroll-trigger',
        'title'             => __('Hero Section mit CTA Scroll Trigger'),
        'description'       => __('Eine Hero-Section mit einem Call-to-Action-Button, der beim Scrollen animiert wird'),
        'render_template'   => 'blocks/hero-section-mit-call-to-action-scroll-trigger/template.php',
        'category'          => 'layout',
        'icon'              => 'cover-image',
        'keywords'          => array('hero', 'cta', 'scroll', 'animation'),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/hero-section-mit-call-to-action-scroll-trigger/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/hero-section-mit-call-to-action-scroll-trigger/script.js',
        'mode'              => 'edit',
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true
        )
    ));
}
