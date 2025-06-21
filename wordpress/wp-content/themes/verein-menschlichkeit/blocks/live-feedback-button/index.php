<?php
/**
 * Block Name: Live-Feedback-Button
 * Description: Ein Button für Live-Feedback von Besuchern
 * Category: menschlichkeit
 * Icon: feedback
 * Keywords: [feedback, button, live, reaktion]
 * 
 * @package Verein-Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Block Registrierung.
 */
function register_live_feedback_button_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'live-feedback-button',
            'title'            => __('Live-Feedback-Button', 'verein-menschlichkeit'),
            'description'      => __('Ein Button für Live-Feedback von Besuchern', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'feedback',
            'keywords'         => array('feedback', 'button', 'live', 'reaktion'),
            'render_template'  => 'blocks/live-feedback-button/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/live-feedback-button/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/live-feedback-button/script.js',
            'supports'         => array(
                'align' => true,
                'mode' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_live_feedback_button_block');
