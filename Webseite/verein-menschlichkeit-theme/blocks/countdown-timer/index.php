<?php
/**
 * Block Name: Countdown Timer
 * Description: Zeigt einen animierten Countdown bis zu einem bestimmten Datum
 * Category: menschlichkeit
 * Icon: clock
 * Keywords: countdown, timer, uhr, event
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_countdown_timer() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'countdown-timer',
            'title'             => __('Countdown Timer', 'menschlichkeit'),
            'description'       => __('Zeigt einen animierten Countdown bis zu einem bestimmten Datum', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'clock',
            'keywords'          => array('countdown', 'timer', 'uhr', 'event'),
            'render_template'   => 'blocks/countdown-timer/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/countdown-timer/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/countdown-timer/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_countdown_timer');
