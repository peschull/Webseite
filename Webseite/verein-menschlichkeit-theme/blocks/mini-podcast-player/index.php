<?php
/**
 * Block Name: Mini-Podcast-Player
 * Description: Ein kompakter Player für Podcast-Episoden
 * Category: menschlichkeit
 * Icon: controls-play
 * Keywords: [podcast, audio, player, episode]
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
function register_mini_podcast_player_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'mini-podcast-player',
            'title'            => __('Mini-Podcast-Player', 'verein-menschlichkeit'),
            'description'      => __('Ein kompakter Player für Podcast-Episoden', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'controls-play',
            'keywords'         => array('podcast', 'audio', 'player', 'episode'),
            'render_template'  => 'blocks/mini-podcast-player/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/mini-podcast-player/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/mini-podcast-player/script.js',
            'supports'         => array(
                'align' => true,
                'mode' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_mini_podcast_player_block');
