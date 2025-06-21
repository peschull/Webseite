<?php
// Block-Registrierung für "Zwei-Spalten-Zitat-Bild" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'zwei-spalten-zitat-bild',
        'title'             => __('Zwei-Spalten-Zitat-Bild'),
        'description'       => __('Ein Block für ein Zitat mit Bild in zwei Spalten.'),
        'render_template'   => 'blocks/zwei-spalten-zitat-bild/template.php',
        'category'          => 'widgets',
        'icon'              => 'format-quote',
        'keywords'          => array( 'zitat', 'bild', 'spalten' ),
    ));
}
