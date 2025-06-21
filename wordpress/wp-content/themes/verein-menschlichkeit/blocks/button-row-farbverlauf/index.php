<?php
/**
 * Block Name: Button Row Farbverlauf
 * Description: Eine Reihe von Buttons mit Farbverlauf
 * Category: menschlichkeit
 * Icon: admin-links
 * Keywords: button, farbverlauf, reihe
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_button_row_farbverlauf() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'button-row-farbverlauf',
            'title'             => __('Button Row Farbverlauf', 'menschlichkeit'),
            'description'       => __('Eine Reihe von Buttons mit Farbverlauf', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'admin-links',
            'keywords'          => array('button', 'farbverlauf', 'reihe'),
            'render_template'   => 'blocks/button-row-farbverlauf/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/button-row-farbverlauf/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/button-row-farbverlauf/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_button_row_farbverlauf');
