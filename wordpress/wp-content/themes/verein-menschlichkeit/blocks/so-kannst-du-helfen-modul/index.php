<?php
/**
 * Block Name: So kannst du helfen Modul
 * Description: Modul mit verschiedenen Möglichkeiten zur Unterstützung
 * Category: menschlichkeit
 * Icon: heart
 * Keywords: helfen, engagement, unterstützung
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_so_kannst_du_helfen_modul() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'so-kannst-du-helfen-modul',
            'title'             => __('So kannst du helfen Modul', 'menschlichkeit'),
            'description'       => __('Modul mit verschiedenen Möglichkeiten zur Unterstützung', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'heart',
            'keywords'          => array('helfen', 'engagement', 'unterstützung'),
            'render_template'   => 'blocks/so-kannst-du-helfen-modul/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/so-kannst-du-helfen-modul/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/so-kannst-du-helfen-modul/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_so_kannst_du_helfen_modul');
