<?php
// Block-Registrierung für "Zitat des Monats" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'zitat-des-monats',
        'title'             => __('Zitat des Monats'),
        'description'       => __('Block für das Zitat des Monats.'),
        'render_template'   => 'blocks/zitat-des-monats/template.php',
        'category'          => 'formatting',
        'icon'              => 'format-quote',
        'keywords'          => array( 'zitat', 'monat', 'quote' ),
    ));
}
