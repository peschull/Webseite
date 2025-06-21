<?php
/**
 * Block Name: Reaktions-Block
 * Description: Ermöglicht Nutzern, auf Inhalte mit Emojis zu reagieren
 * Category: menschlichkeit
 * Icon: smiley
 * Keywords: reaktion, emoji, feedback
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_reaktions_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'reaktions-block',
            'title'             => __('Reaktions-Block', 'menschlichkeit'),
            'description'       => __('Ermöglicht Nutzern, auf Inhalte mit Emojis zu reagieren', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'smiley',
            'keywords'          => array('reaktion', 'emoji', 'feedback'),
            'render_template'   => 'blocks/reaktions-block/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/reaktions-block/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/reaktions-block/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_reaktions_block');
