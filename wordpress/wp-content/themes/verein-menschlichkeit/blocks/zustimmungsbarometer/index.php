<?php
// Block-Registrierung für "Zustimmungsbarometer" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'zustimmungsbarometer',
        'title'             => __('Zustimmungsbarometer'),
        'description'       => __('Ein Block für ein Zustimmungsbarometer.'),
        'render_template'   => 'blocks/zustimmungsbarometer/template.php',
        'category'          => 'widgets',
        'icon'              => 'smiley',
        'keywords'          => array( 'zustimmung', 'barometer', 'umfrage' ),
    ));
}
