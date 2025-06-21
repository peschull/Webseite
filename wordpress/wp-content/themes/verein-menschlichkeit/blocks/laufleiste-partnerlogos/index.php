<?php
// Block-Registrierung für "Laufleiste Partnerlogos" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'laufleiste-partnerlogos',
        'title'             => __('Laufleiste Partnerlogos'),
        'description'       => __('Ein Block für eine Laufleiste mit Partnerlogos.'),
        'render_template'   => 'blocks/laufleiste-partnerlogos/template.php',
        'category'          => 'widgets',
        'icon'              => 'images-alt2',
        'keywords'          => array( 'laufleiste', 'partner', 'logos' ),
    ));
}
