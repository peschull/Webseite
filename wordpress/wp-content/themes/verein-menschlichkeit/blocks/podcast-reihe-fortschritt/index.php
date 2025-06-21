<?php
// Block-Registrierung für "podcast-reihe-fortschritt" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'podcast-reihe-fortschritt',
        'title'             => __('Podcast-Reihe Fortschritt', 'verein-menschlichkeit'),
        'description'       => __('Block für eine Podcast-Reihe mit Fortschrittsanzeige.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'microphone',
        'keywords'          => array( 'podcast', 'reihe', 'fortschritt' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/podcast-reihe-fortschritt/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/podcast-reihe-fortschritt/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
