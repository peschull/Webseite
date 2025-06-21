<?php
// Block-Registrierung für "stimmungsumfrage" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'stimmungsumfrage',
        'title'             => __('Stimmungsumfrage', 'verein-menschlichkeit'),
        'description'       => __('Block für eine Stimmungsumfrage.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'smiley',
        'keywords'          => array( 'stimmung', 'umfrage', 'feedback' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/stimmungsumfrage/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/stimmungsumfrage/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
