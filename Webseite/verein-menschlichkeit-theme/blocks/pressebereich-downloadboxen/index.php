<?php
/**
 * Block Name: Pressebereich Downloadboxen
 * Description: Downloadboxen für Pressemitteilungen und Medien
 * Category: menschlichkeit
 * Icon: media-document
 * Keywords: presse, download, medien, boxen
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_pressebereich_downloadboxen() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'pressebereich-downloadboxen',
            'title'             => __('Pressebereich Downloadboxen', 'menschlichkeit'),
            'description'       => __('Downloadboxen für Pressemitteilungen und Medien', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'media-document',
            'keywords'          => array('presse', 'download', 'medien', 'boxen'),
            'render_template'   => 'blocks/pressebereich-downloadboxen/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/pressebereich-downloadboxen/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/pressebereich-downloadboxen/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_pressebereich_downloadboxen');
