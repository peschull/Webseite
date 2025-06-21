<?php
// Block-Registrierung für "Statuten Accordion" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'statuten-accordion',
        'title'             => __('Statuten Accordion'),
        'description'       => __('Ein Block für ein Akkordeon mit Statuten.'),
        'render_template'   => 'blocks/statuten-accordion/template.php',
        'category'          => 'widgets',
        'icon'              => 'list-view',
        'keywords'          => array( 'statuten', 'accordion', 'akkordeon' ),
    ));
}
