<?php
/**
 * ACF Felder für den Block Partnerschaften Logo-Reihe
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_partnerschaften_logo_reihe',
    'title' => 'Partnerschaften Logo-Reihe',
    'fields' => array(
        array(
            'key' => 'field_partnerschaften_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für die Logo-Reihe',
            'required' => 0,
        ),
        array(
            'key' => 'field_logos',
            'label' => 'Logos',
            'name' => 'logos',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Logos von Partnern hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_logo_bild',
                    'label' => 'Logo',
                    'name' => 'bild',
                    'type' => 'image',
                    'required' => 1,
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_logo_link',
                    'label' => 'Link (optional)',
                    'name' => 'link',
                    'type' => 'url',
                    'required' => 0,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/partnerschaften-logo-reihe',
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
