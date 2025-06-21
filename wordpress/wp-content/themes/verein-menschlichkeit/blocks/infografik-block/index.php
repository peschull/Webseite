<?php
/**
 * Block Name: Infografik Block
 * Description: Zeigt eine Infografik mit optionalen Texten an
 * Category: menschlichkeit
 * Icon: chart-bar
 * Keywords: infografik, grafik, visualisierung
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_infografik_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'infografik-block',
            'title'             => __('Infografik Block', 'menschlichkeit'),
            'description'       => __('Zeigt eine Infografik mit optionalen Texten an', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'chart-bar',
            'keywords'          => array('infografik', 'grafik', 'visualisierung'),
            'render_template'   => 'blocks/infografik-block/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/infografik-block/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/infografik-block/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_infografik_block');
