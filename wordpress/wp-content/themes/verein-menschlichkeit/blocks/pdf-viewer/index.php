<?php
/**
 * Block Name: PDF-Viewer
 * Description: Ein eingebetteter PDF-Viewer mit Download-Option
 * Category: menschlichkeit
 * Icon: pdf
 * Keywords: [pdf, dokument, viewer, download]
 * 
 * @package Verein-Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Block Registrierung.
 */
function register_pdf_viewer_block() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'pdf-viewer',
            'title'            => __('PDF-Viewer', 'verein-menschlichkeit'),
            'description'      => __('Ein eingebetteter PDF-Viewer mit Download-Option', 'verein-menschlichkeit'),
            'category'         => 'menschlichkeit',
            'icon'             => 'pdf',
            'keywords'         => array('pdf', 'dokument', 'viewer', 'download'),
            'render_template'  => 'blocks/pdf-viewer/template.php',
            'enqueue_style'    => get_template_directory_uri() . '/blocks/pdf-viewer/style.css',
            'enqueue_script'   => get_template_directory_uri() . '/blocks/pdf-viewer/script.js',
            'supports'         => array(
                'align' => true,
                'mode' => true
            ),
        ));
    }
}
add_action('acf/init', 'register_pdf_viewer_block');
