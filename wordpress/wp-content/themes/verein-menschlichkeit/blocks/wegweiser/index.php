<?php
// Block-Registrierung für "Wegweiser" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'wegweiser',
        'title'             => __('Wegweiser'),
        'description'       => __('Ein Block für einen Wegweiser.'),
        'render_template'   => 'blocks/wegweiser/template.php',
        'category'          => 'widgets',
        'icon'              => 'location',
        'keywords'          => array( 'wegweiser', 'navigation', 'hinweis' ),
    ));
}
