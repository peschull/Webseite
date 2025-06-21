<?php
// Block-Registrierung für "Wichtige Zahlen 2024" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'wichtige-zahlen-2024',
        'title'             => __('Wichtige Zahlen 2024'),
        'description'       => __('Ein Block für wichtige Zahlen des Jahres 2024.'),
        'render_template'   => 'blocks/wichtige-zahlen-2024/template.php',
        'category'          => 'widgets',
        'icon'              => 'chart-line',
        'keywords'          => array( 'zahlen', '2024', 'statistik' ),
    ));
}
