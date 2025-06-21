<?php
// Block-Registrierung für "Vor-Ort-Galerie" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'vor-ort-galerie',
        'title'             => __('Vor-Ort-Galerie'),
        'description'       => __('Ein Block für eine Galerie vor Ort.'),
        'render_template'   => 'blocks/vor-ort-galerie/template.php',
        'category'          => 'media',
        'icon'              => 'format-gallery',
        'keywords'          => array( 'galerie', 'vor ort', 'bilder' ),
    ));
}
