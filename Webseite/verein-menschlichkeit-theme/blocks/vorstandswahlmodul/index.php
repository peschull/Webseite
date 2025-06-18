<?php
// Block-Registrierung für "Vorstandswahlmodul" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'vorstandswahlmodul',
        'title'             => __('Vorstandswahlmodul'),
        'description'       => __('Ein Block für das Vorstandswahlmodul.'),
        'render_template'   => 'blocks/vorstandswahlmodul/template.php',
        'category'          => 'widgets',
        'icon'              => 'groups',
        'keywords'          => array( 'vorstand', 'wahl', 'modul' ),
    ));
}
