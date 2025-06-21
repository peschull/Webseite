<?php
// Block-Registrierung für "textzitat-grossinitial" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'textzitat-grossinitial',
        'title'             => __('Textzitat Großinitial', 'verein-menschlichkeit'),
        'description'       => __('Block für ein Zitat mit großer Initiale.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'format-quote',
        'keywords'          => array( 'zitat', 'text', 'großinitial' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/textzitat-grossinitial/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/textzitat-grossinitial/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
