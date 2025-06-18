<?php
// Block-Registrierung für "mini-faq-am-rand" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'mini-faq-am-rand',
        'title'             => __('Mini FAQ am Rand', 'verein-menschlichkeit'),
        'description'       => __('Block für eine kleine FAQ am Rand.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'editor-help',
        'keywords'          => array( 'faq', 'mini', 'rand' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/mini-faq-am-rand/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/mini-faq-am-rand/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
