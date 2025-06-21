<?php
/**
 * Block Name: Timeline Meilensteine
 * Description: Zeigt eine Timeline mit Meilensteinen an
 * Category: menschlichkeit
 * Icon: dashicons-clock
 * Keywords: timeline, meilensteine, verlauf
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_timeline_meilensteine() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'timeline-meilensteine',
            'title'             => __('Timeline Meilensteine', 'menschlichkeit'),
            'description'       => __('Zeigt eine Timeline mit Meilensteinen an', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'clock',
            'keywords'          => array('timeline', 'meilensteine', 'verlauf'),
            'render_template'   => 'blocks/timeline-meilensteine/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/timeline-meilensteine/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/timeline-meilensteine/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_timeline_meilensteine');
