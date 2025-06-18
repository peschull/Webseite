<?php
// Block-Registrierung für "terminbuchung" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'terminbuchung',
        'title'             => __('Terminbuchung', 'verein-menschlichkeit'),
        'description'       => __('Block für die Buchung von Terminen.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'calendar-alt',
        'keywords'          => array( 'termin', 'buchung', 'kalender' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/terminbuchung/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/terminbuchung/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
