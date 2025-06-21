<?php
// Block-Registrierung für "faq-quiz-kombiblock" via ACF
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'faq-quiz-kombiblock',
        'title'             => __('FAQ-Quiz Kombiblock', 'verein-menschlichkeit'),
        'description'       => __('Ein Block, der FAQ und Quiz kombiniert.', 'verein-menschlichkeit'),
        'render_template'   => __DIR__ . '/template.php',
        'category'          => 'widgets',
        'icon'              => 'editor-help',
        'keywords'          => array( 'faq', 'quiz', 'kombiblock' ),
        'enqueue_style'     => get_template_directory_uri() . '/blocks/faq-quiz-kombiblock/style.css',
        'enqueue_script'    => get_template_directory_uri() . '/blocks/faq-quiz-kombiblock/script.js',
        'supports'          => array( 'align' => false ),
    ));
}
