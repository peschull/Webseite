<?php
/**
 * Block Name: Projekt Grid mit Filter
 * Description: Ein Grid-Layout für Projekte mit Filterfunktion nach Kategorien
 * Category: content
 * Icon: grid-view
 * Keywords: projekte, grid, filter, kategorien
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Register Block
if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
        'name'              => 'projekt-grid-mit-filter',
        'title'             => __('Projekt Grid mit Filter'),
        'description'       => __('Ein Grid-Layout für Projekte mit Filterfunktion nach Kategorien'),
        'render_template'   => 'blocks/projekt-grid-mit-filter/template.php',
        'category'          => 'content',
        'icon'              => 'grid-view',
        'keywords'          => array('projekte', 'grid', 'filter', 'kategorien'),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/projekt-grid-mit-filter/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/projekt-grid-mit-filter/script.js',
        'mode'              => 'edit',
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true
        )
    ));
}
