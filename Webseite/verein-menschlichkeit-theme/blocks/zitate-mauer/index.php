<?php
/**
 * Block Name: Zitate-Mauer
 * Description: Eine Mauer aus Zitaten, flexibel anzuordnen
 * Category: menschlichkeit
 * Icon: format-quote
 * Keywords: zitate, mauer, testimonials
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_zitate_mauer() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'zitate-mauer',
            'title'             => __('Zitate-Mauer', 'menschlichkeit'),
            'description'       => __('Eine Mauer aus Zitaten, flexibel anzuordnen', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'format-quote',
            'keywords'          => array('zitate', 'mauer', 'testimonials'),
            'render_template'   => 'blocks/zitate-mauer/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/zitate-mauer/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/zitate-mauer/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_zitate_mauer');
