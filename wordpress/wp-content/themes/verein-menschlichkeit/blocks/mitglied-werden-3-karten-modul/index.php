<?php
/**
 * Block Name: Mitglied werden 3-Karten-Modul
 * Description: Ein Modul mit drei Karten zur Darstellung verschiedener Mitgliedschaftsoptionen
 * Category: content
 * Icon: id-alt
 * Keywords: mitglied, karten, optionen, beitritt
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Register Block
if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
        'name'              => 'mitglied-werden-3-karten-modul',
        'title'             => __('Mitglied werden 3-Karten-Modul'),
        'description'       => __('Ein Modul mit drei Karten zur Darstellung verschiedener Mitgliedschaftsoptionen'),
        'render_template'   => 'blocks/mitglied-werden-3-karten-modul/template.php',
        'category'          => 'content',
        'icon'              => 'id-alt',
        'keywords'          => array('mitglied', 'karten', 'optionen', 'beitritt'),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/mitglied-werden-3-karten-modul/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/mitglied-werden-3-karten-modul/script.js',
        'mode'              => 'edit',
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true
        )
    ));
}
