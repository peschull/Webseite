<?php
/**
 * ACF Felder für Blog Kachelgrid
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_blog_kachelgrid',
    'title' => 'Blog Kachelgrid',
    'fields' => array(
        array(
            'key' => 'field_bloggrid_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für das Grid',
            'required' => 0,
        ),
        array(
            'key' => 'field_bloggrid_anzahl',
            'label' => 'Anzahl Beiträge',
            'name' => 'anzahl',
            'type' => 'number',
            'instructions' => 'Wie viele Beiträge sollen angezeigt werden?',
            'required' => 0,
            'default_value' => 6,
            'min' => 1,
            'max' => 24,
            'step' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/blog-kachelgrid',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
));

endif;
