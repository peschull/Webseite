<?php
/**
 * Block Name: Spendenfortschritt Animiert
 * Description: Ein Block zur animierten Darstellung des Spendenfortschritts mit Zielerreichung
 * Category: content
 * Icon: chart-bar
 * Keywords: spenden, fortschritt, ziel, animation
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Register Block
if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
        'name'              => 'spendenfortschritt-animiert',
        'title'             => __('Spendenfortschritt Animiert'),
        'description'       => __('Ein Block zur animierten Darstellung des Spendenfortschritts mit Zielerreichung'),
        'render_template'   => 'blocks/spendenfortschritt-animiert/template.php',
        'category'          => 'content',
        'icon'              => 'chart-bar',
        'keywords'          => array('spenden', 'fortschritt', 'ziel', 'animation'),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/spendenfortschritt-animiert/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/spendenfortschritt-animiert/script.js',
        'mode'              => 'edit',
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true
        )
    ));
}
