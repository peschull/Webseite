<?php
// Block-Registrierung für "Live-Suchfeld" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'live-suchfeld',
        'title'             => __('Live-Suchfeld'),
        'description'       => __('Ein Block für ein Live-Suchfeld.'),
        'render_template'   => 'blocks/live-suchfeld/template.php',
        'category'          => 'widgets',
        'icon'              => 'search',
        'keywords'          => array( 'suche', 'suchfeld', 'live' ),
    ));
}
