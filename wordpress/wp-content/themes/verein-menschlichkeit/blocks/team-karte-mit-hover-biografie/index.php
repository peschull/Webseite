<?php
/**
 * Block Name: Team Karte mit Hover Biografie
 * Description: Eine Teamkarte, die bei Hover zusätzliche biografische Informationen anzeigt
 * Category: content
 * Icon: groups
 * Keywords: team, karte, biografie, hover
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Register Block
if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
        'name'              => 'team-karte-mit-hover-biografie',
        'title'             => __('Team Karte mit Hover Biografie'),
        'description'       => __('Eine Teamkarte, die bei Hover zusätzliche biografische Informationen anzeigt'),
        'render_template'   => 'blocks/team-karte-mit-hover-biografie/template.php',
        'category'          => 'content',
        'icon'              => 'groups',
        'keywords'          => array('team', 'karte', 'biografie', 'hover'),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/team-karte-mit-hover-biografie/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/team-karte-mit-hover-biografie/script.js',
        'mode'              => 'edit',
        'supports'          => array(
            'align' => true,
            'mode' => false,
            'jsx' => true
        )
    ));
}
