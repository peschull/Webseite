<?php
// Block-Registrierung für "Wortwolke" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'wortwolke',
        'title'             => __('Wortwolke'),
        'description'       => __('Ein Block für eine Wortwolke.'),
        'render_template'   => 'blocks/wortwolke/template.php',
        'category'          => 'formatting',
        'icon'              => 'cloud',
        'keywords'          => array( 'wortwolke', 'cloud', 'text' ),
    ));
}
