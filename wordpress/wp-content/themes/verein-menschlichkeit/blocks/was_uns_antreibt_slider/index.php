<?php
// Block-Registrierung für "Was uns antreibt Slider" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'was_uns_antreibt_slider',
        'title'             => __('Was uns antreibt Slider'),
        'description'       => __('Ein Block für einen Slider mit Motivationssprüchen.'),
        'render_template'   => 'blocks/was_uns_antreibt_slider/template.php',
        'category'          => 'widgets',
        'icon'              => 'slides',
        'keywords'          => array( 'slider', 'motivation', 'antrieb' ),
    ));
}
