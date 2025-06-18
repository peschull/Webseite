<?php
/**
 * Block Name: Partnerschaften Logo-Reihe
 * Description: Zeigt eine Reihe von Partner-Logos mit optionalen Links an
 * Category: menschlichkeit
 * Icon: networking
 * Keywords: partner, logos, kooperation
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_partnerschaften_logo_reihe() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'partnerschaften-logo-reihe',
            'title'             => __('Partnerschaften Logo-Reihe', 'menschlichkeit'),
            'description'       => __('Zeigt eine Reihe von Partner-Logos mit optionalen Links an', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'networking',
            'keywords'          => array('partner', 'logos', 'kooperation'),
            'render_template'   => 'blocks/partnerschaften-logo-reihe/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/partnerschaften-logo-reihe/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/partnerschaften-logo-reihe/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_partnerschaften_logo_reihe');
