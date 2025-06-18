<?php
// Block-Registrierung für "Mitmach-Voting" Gutenberg/ACF-Block
if( function_exists('acf_register_block_type') ) {
    acf_register_block_type(array(
        'name'              => 'mitmach-voting',
        'title'             => __('Mitmach-Voting'),
        'description'       => __('Ein Block für Mitmach-Voting.'),
        'render_template'   => 'blocks/mitmach-voting/template.php',
        'category'          => 'widgets',
        'icon'              => 'yes',
        'keywords'          => array( 'voting', 'mitmachen', 'abstimmung' ),
    ));
}
