<?php
/**
 * ACF Felder für das So kannst du helfen Modul
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_so_kannst_du_helfen_modul',
    'title' => 'So kannst du helfen Modul',
    'fields' => array(
        array(
            'key' => 'field_helfen_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für das Modul',
            'required' => 0,
        ),
        array(
            'key' => 'field_hilfemöglichkeiten',
            'label' => 'Hilfemöglichkeiten',
            'name' => 'hilfemöglichkeiten',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie verschiedene Möglichkeiten hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_hilfe_icon',
                    'label' => 'Icon',
                    'name' => 'icon',
                    'type' => 'image',
                    'required' => 0,
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_hilfe_titel',
                    'label' => 'Titel',
                    'name' => 'titel',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_hilfe_beschreibung',
                    'label' => 'Beschreibung',
                    'name' => 'beschreibung',
                    'type' => 'textarea',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_hilfe_link',
                    'label' => 'Link',
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
                'value' => 'acf/so-kannst-du-helfen-modul',
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
