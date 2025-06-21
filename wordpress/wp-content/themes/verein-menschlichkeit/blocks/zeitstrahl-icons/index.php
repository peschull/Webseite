<?php
// Block-Registrierung für "Zeitstrahl Icons" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'zeitstrahl-icons',
        'title'             => __('Zeitstrahl Icons'),
        'description'       => __('Ein Block für einen Zeitstrahl mit Icons.'),
        'render_template'   => 'blocks/zeitstrahl-icons/template.php',
        'category'          => 'widgets',
        'icon'              => 'clock',
        'keywords'          => array( 'zeitstrahl', 'icons', 'timeline' ),
    ));
}
