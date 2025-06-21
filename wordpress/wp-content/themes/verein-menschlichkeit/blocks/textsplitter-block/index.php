<?php
// Block-Registrierung für "textsplitter-block" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'textsplitter-block',
        'title'             => __('Textsplitter Block', 'verein-menschlichkeit'),
        'description'       => __('Block für geteilte Textabschnitte.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'editor-table',
        'keywords'          => array( 'text', 'splitter', 'abschnitt' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/textsplitter-block/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/textsplitter-block/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
