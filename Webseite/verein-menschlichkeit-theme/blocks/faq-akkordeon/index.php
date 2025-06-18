<?php
/**
 * Block Name: FAQ Akkordeon
 * Description: Klappbare FAQ-Liste als Akkordeon
 * Category: menschlichkeit
 * Icon: editor-help
 * Keywords: faq, akkordeon, fragen, antworten
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_faq_akkordeon() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'faq-akkordeon',
            'title'             => __('FAQ Akkordeon', 'menschlichkeit'),
            'description'       => __('Klappbare FAQ-Liste als Akkordeon', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'editor-help',
            'keywords'          => array('faq', 'akkordeon', 'fragen', 'antworten'),
            'render_template'   => 'blocks/faq-akkordeon/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/faq-akkordeon/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/faq-akkordeon/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_faq_akkordeon');
