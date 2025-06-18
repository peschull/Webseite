<?php
// Block-Registrierung für "beteiligungskarte" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'beteiligungskarte',
        'title'             => __('Beteiligungskarte', 'verein-menschlichkeit'),
        'description'       => __('Block für eine Beteiligungskarte.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'location-alt',
        'keywords'          => array( 'beteiligung', 'karte', 'map' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/beteiligungskarte/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/beteiligungskarte/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
