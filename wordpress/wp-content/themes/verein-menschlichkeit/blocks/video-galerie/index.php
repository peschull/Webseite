<?php
// Block-Registrierung für "Video-Galerie" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'video-galerie',
        'title'             => __('Video-Galerie'),
        'description'       => __('Ein Block für eine Video-Galerie.'),
        'render_template'   => 'blocks/video-galerie/template.php',
        'category'          => 'media',
        'icon'              => 'format-video',
        'keywords'          => array( 'video', 'galerie', 'media' ),
    ));
}
