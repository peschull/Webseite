<?php
// Block-Registrierung für "fortschrittsbaum" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'fortschrittsbaum',
        'title'             => __('Fortschrittsbaum', 'verein-menschlichkeit'),
        'description'       => __('Block für einen Fortschrittsbaum.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'tree',
        'keywords'          => array( 'fortschritt', 'baum', 'visualisierung' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/fortschrittsbaum/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/fortschrittsbaum/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
