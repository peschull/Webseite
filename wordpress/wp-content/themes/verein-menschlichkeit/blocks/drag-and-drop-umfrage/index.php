<?php
// Block-Registrierung für "drag-and-drop-umfrage" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'drag-and-drop-umfrage',
        'title'             => __('Drag & Drop Umfrage', 'verein-menschlichkeit'),
        'description'       => __('Ein Block für Drag & Drop Umfragen.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'feedback',
        'keywords'          => array( 'umfrage', 'drag', 'drop' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/drag-and-drop-umfrage/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/drag-and-drop-umfrage/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
