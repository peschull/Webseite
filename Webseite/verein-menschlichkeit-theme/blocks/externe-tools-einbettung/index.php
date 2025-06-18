<?php
// Block-Registrierung für "externe-tools-einbettung" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'externe-tools-einbettung',
        'title'             => __('Externe Tools Einbettung', 'verein-menschlichkeit'),
        'description'       => __('Block zur Einbettung externer Tools.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'admin-site-alt3',
        'keywords'          => array( 'extern', 'tool', 'einbettung' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/externe-tools-einbettung/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/externe-tools-einbettung/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
