<?php
/**
 * Block Name: Newsletter Opt-in DSGVO
 * Description: Ein Newsletter-Anmeldeformular mit DSGVO-konformem Double-Opt-in
 * Category: forms
 * Icon: email
 * Keywords: newsletter, anmeldung, dsgvo, opt-in
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Register Block
if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
        'name'              => 'newsletter-opt-in-dsgvo',
        'title'             => __('Newsletter Opt-in DSGVO'),
        'description'       => __('Ein Newsletter-Anmeldeformular mit DSGVO-konformem Double-Opt-in'),
        'render_template'   => 'blocks/newsletter-opt-in-dsgvo/template.php',
        'category'          => 'forms',
        'icon'              => 'email',
        'keywords'          => array('newsletter', 'anmeldung', 'dsgvo', 'opt-in'),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/newsletter-opt-in-dsgvo/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/newsletter-opt-in-dsgvo/script.js',
        'mode'              => 'edit',
        'supports'          => array(
            'align' => false,
            'mode' => false,
            'jsx' => true
        )
    ));
}
