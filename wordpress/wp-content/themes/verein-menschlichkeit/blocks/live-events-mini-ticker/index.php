<?php
// Block-Registrierung für "live-events-mini-ticker" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'live-events-mini-ticker',
        'title'             => __('Live Events Mini Ticker', 'verein-menschlichkeit'),
        'description'       => __('Block für einen Mini-Ticker mit Live-Events.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'clock',
        'keywords'          => array( 'live', 'events', 'ticker' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/live-events-mini-ticker/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/live-events-mini-ticker/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
