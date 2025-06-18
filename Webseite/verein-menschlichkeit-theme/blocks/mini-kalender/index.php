<?php
// Block-Registrierung für "mini-kalender" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'mini-kalender',
        'title'             => __('Mini Kalender', 'verein-menschlichkeit'),
        'description'       => __('Block für einen kleinen Kalender.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'calendar-alt',
        'keywords'          => array( 'kalender', 'mini', 'datum' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/mini-kalender/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/mini-kalender/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
