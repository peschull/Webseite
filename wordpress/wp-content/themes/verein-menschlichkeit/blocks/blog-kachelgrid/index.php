<?php
/**
 * Block Name: Blog Kachelgrid
 * Description: Grid-Layout für Blogbeiträge als Kacheln
 * Category: menschlichkeit
 * Icon: grid-view
 * Keywords: blog, grid, kacheln
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

function register_acf_block_blog_kachelgrid() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'blog-kachelgrid',
            'title'             => __('Blog Kachelgrid', 'menschlichkeit'),
            'description'       => __('Grid-Layout für Blogbeiträge als Kacheln', 'menschlichkeit'),
            'category'          => 'menschlichkeit',
            'icon'              => 'grid-view',
            'keywords'          => array('blog', 'grid', 'kacheln'),
            'render_template'   => 'blocks/blog-kachelgrid/template.php',
            'enqueue_style'     => get_template_directory_uri() . '/blocks/blog-kachelgrid/style.css',
            'enqueue_script'    => get_template_directory_uri() . '/blocks/blog-kachelgrid/script.js',
            'mode'              => 'edit',
            'supports'          => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'register_acf_block_blog_kachelgrid');
