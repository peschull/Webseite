<?php
// Block-Registrierung für "unterstuetzungslevel" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'unterstuetzungslevel',
        'title'             => __('Unterstützungslevel', 'verein-menschlichkeit'),
        'description'       => __('Block für verschiedene Unterstützungslevel.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'awards',
        'keywords'          => array( 'unterstützung', 'level', 'stufen' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/unterstuetzungslevel/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/unterstuetzungslevel/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
