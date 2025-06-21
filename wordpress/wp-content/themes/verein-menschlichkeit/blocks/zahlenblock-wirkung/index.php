<?php
// Block-Registrierung für "Zahlenblock Wirkung" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'zahlenblock-wirkung',
        'title'             => __('Zahlenblock Wirkung'),
        'description'       => __('Ein Block für Zahlen und Wirkung.'),
        'render_template'   => 'blocks/zahlenblock-wirkung/template.php',
        'category'          => 'widgets',
        'icon'              => 'chart-bar',
        'keywords'          => array( 'zahlen', 'wirkung', 'statistik' ),
    ));
}
