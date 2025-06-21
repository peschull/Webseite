<?php
// Block-Registrierung für "Zählbalken Engagement Ziel" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'zaehlbalken-engagement-ziel',
        'title'             => __('Zählbalken Engagement Ziel'),
        'description'       => __('Ein Block für einen Zählbalken zum Engagement-Ziel.'),
        'render_template'   => 'blocks/zaehlbalken-engagement-ziel/template.php',
        'category'          => 'widgets',
        'icon'              => 'chart-bar',
        'keywords'          => array( 'zaehlbalken', 'engagement', 'ziel' ),
    ));
}
