<?php
// Block-Registrierung für "Mitgliederkarte" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'mitgliederkarte',
        'title'             => __('Mitgliederkarte'),
        'description'       => __('Ein Block für eine Mitgliederkarte.'),
        'render_template'   => 'blocks/mitgliederkarte/template.php',
        'category'          => 'widgets',
        'icon'              => 'groups',
        'keywords'          => array( 'mitglieder', 'karte', 'map' ),
    ));
}
