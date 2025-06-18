<?php
/**
 * Block Name: Mitmach-Checkliste
 * Description: Interaktive Checkliste für Mitmach-Aktionen
 * Category: menschlichkeit
 * Icon: yes
 * Keywords: checkliste, mitmachen, todo
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_mitmach_checkliste() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'mitmach-checkliste',
            'title'             => __('Mitmach-Checkliste', 'menschlichkeit'),
            'description'       => __('Interaktive Checkliste für Mitmach-Aktionen', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'yes',
            'keywords'          => array('checkliste', 'mitmachen', 'todo'),
            'render_template'   => 'blocks/mitmach-checkliste/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/mitmach-checkliste/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/mitmach-checkliste/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_mitmach_checkliste');
