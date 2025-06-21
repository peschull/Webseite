<?php
// Block-Registrierung für "event-box" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'event-box',
        'title'             => __('Event Box', 'verein-menschlichkeit'),
        'description'       => __('Ein Block zur Darstellung von Events.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'calendar',
        'keywords'          => array( 'event', 'termin', 'veranstaltung' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/event-box/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/event-box/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
