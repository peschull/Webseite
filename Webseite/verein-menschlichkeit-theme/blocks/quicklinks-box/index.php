<?php
// Block-Registrierung für "quicklinks-box" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'quicklinks-box',
        'title'             => __('Quicklinks Box', 'verein-menschlichkeit'),
        'description'       => __('Block für eine Box mit Quicklinks.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'admin-links',
        'keywords'          => array( 'quicklinks', 'links', 'box' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/quicklinks-box/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/quicklinks-box/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
