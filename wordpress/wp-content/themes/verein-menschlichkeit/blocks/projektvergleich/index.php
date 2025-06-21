<?php
// Block-Registrierung für "projektvergleich" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'projektvergleich',
        'title'             => __('Projektvergleich', 'verein-menschlichkeit'),
        'description'       => __('Block für den Vergleich von Projekten.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'chart-bar',
        'keywords'          => array( 'projekt', 'vergleich', 'projekte' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/projektvergleich/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/projektvergleich/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
