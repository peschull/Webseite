<?php
// Block-Registrierung für "redaktionsteam-vorstellung" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'redaktionsteam-vorstellung',
        'title'             => __('Redaktionsteam Vorstellung', 'verein-menschlichkeit'),
        'description'       => __('Block zur Vorstellung des Redaktionsteams.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'groups',
        'keywords'          => array( 'redaktion', 'team', 'vorstellung' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/redaktionsteam-vorstellung/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/redaktionsteam-vorstellung/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
