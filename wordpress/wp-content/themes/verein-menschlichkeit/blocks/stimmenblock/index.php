<?php
// Block-Registrierung für "Stimmenblock" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'stimmenblock',
        'title'             => __('Stimmenblock'),
        'description'       => __('Ein Block für Stimmen und Meinungen.'),
        'render_template'   => 'blocks/stimmenblock/template.php',
        'category'          => 'widgets',
        'icon'              => 'format-quote',
        'keywords'          => array( 'stimmen', 'meinung', 'zitat' ),
    ));
}
