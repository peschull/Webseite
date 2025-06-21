<?php
/**
 * Block Name: Vorlese-Block
 * Description: Text mit Vorlese-Funktion (Text-to-Speech)
 * Category: menschlichkeit
 * Icon: megaphone
 * Keywords: vorlesen, tts, barrierefreiheit
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_vorlese_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'vorlese-block',
            'title'             => __('Vorlese-Block', 'menschlichkeit'),
            'description'       => __('Text mit Vorlese-Funktion (Text-to-Speech)', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'megaphone',
            'keywords'          => array('vorlesen', 'tts', 'barrierefreiheit'),
            'render_template'   => 'blocks/vorlese-block/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/vorlese-block/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/vorlese-block/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_vorlese_block');
