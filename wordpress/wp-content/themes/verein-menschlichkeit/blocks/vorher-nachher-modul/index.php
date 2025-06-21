<?php
// Block-Registrierung für "vorher-nachher-modul" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'vorher-nachher-modul',
        'title'             => __('Vorher-Nachher Modul', 'verein-menschlichkeit'),
        'description'       => __('Block für Vorher-Nachher Bildvergleiche.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'image-flip-horizontal',
        'keywords'          => array( 'vorher', 'nachher', 'bildvergleich' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/vorher-nachher-modul/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/vorher-nachher-modul/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
