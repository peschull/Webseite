<?php
// Block-Registrierung für "karussell-unterstuetzungsarten" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'karussell-unterstuetzungsarten',
        'title'             => __('Karussell Unterstützungsarten', 'verein-menschlichkeit'),
        'description'       => __('Block für ein Karussell verschiedener Unterstützungsarten.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'slides',
        'keywords'          => array( 'karussell', 'unterstützung', 'arten' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/karussell-unterstuetzungsarten/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/karussell-unterstuetzungsarten/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
