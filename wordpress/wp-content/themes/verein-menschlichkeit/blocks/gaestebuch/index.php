<?php
// Block-Registrierung für "Gästebuch" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'gaestebuch',
        'title'             => __('Gästebuch'),
        'description'       => __('Ein Block für ein Gästebuch.'),
        'render_template'   => 'blocks/gaestebuch/template.php',
        'category'          => 'widgets',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'gästebuch', 'guestbook', 'kommentar' ),
    ));
}
