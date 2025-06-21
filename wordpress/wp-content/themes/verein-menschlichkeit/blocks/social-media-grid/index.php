<?php
// Block-Registrierung für "Social Media Grid" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'social-media-grid',
        'title'             => __('Social Media Grid'),
        'description'       => __('Ein Block für ein Social Media Grid.'),
        'render_template'   => 'blocks/social-media-grid/template.php',
        'category'          => 'widgets',
        'icon'              => 'share',
        'keywords'          => array( 'social', 'media', 'grid' ),
    ));
}
