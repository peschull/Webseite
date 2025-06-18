<?php
// Block-Registrierung für "projektuebersicht-timeline-balken" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'projektuebersicht-timeline-balken',
        'title'             => __('Projektübersicht Timeline Balken', 'verein-menschlichkeit'),
        'description'       => __('Block für eine Timeline mit Balken zur Projektübersicht.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'schedule',
        'keywords'          => array( 'projekt', 'timeline', 'balken' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/projektuebersicht-timeline-balken/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/projektuebersicht-timeline-balken/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
