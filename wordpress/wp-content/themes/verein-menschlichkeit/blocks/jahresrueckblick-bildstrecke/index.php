<?php
// Block-Registrierung für "jahresrueckblick-bildstrecke" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'jahresrueckblick-bildstrecke',
        'title'             => __('Jahresrückblick Bildstrecke', 'verein-menschlichkeit'),
        'description'       => __('Block für eine Bildstrecke zum Jahresrückblick.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'images-alt2',
        'keywords'          => array( 'jahresrückblick', 'bildstrecke', 'bilder' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/jahresrueckblick-bildstrecke/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/jahresrueckblick-bildstrecke/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
