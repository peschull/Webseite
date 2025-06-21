<?php
// Block-Registrierung für "schnell-umfrage-footer" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'schnell-umfrage-footer',
        'title'             => __('Schnell-Umfrage Footer', 'verein-menschlichkeit'),
        'description'       => __('Block für eine schnelle Umfrage im Footer.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'feedback',
        'keywords'          => array( 'umfrage', 'footer', 'schnell' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/schnell-umfrage-footer/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/schnell-umfrage-footer/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
