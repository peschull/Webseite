<?php
// Block-Registrierung für "dialogblock" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'dialogblock',
        'title'             => __('Dialogblock', 'verein-menschlichkeit'),
        'description'       => __('Block für einen Dialog zwischen zwei Personen.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'format-chat',
        'keywords'          => array( 'dialog', 'gespräch', 'personen' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/dialogblock/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/dialogblock/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
