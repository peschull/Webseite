<?php
/**
 * ACF Felder für Projekt-Scroller
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_projekt_scroller',
    'title' => 'Projekt-Scroller',
    'fields' => array(
        array(
            'key' => 'field_projekt_scroller_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für den Scroller',
            'required' => 0,
        ),
        array(
            'key' => 'field_projekte',
            'label' => 'Projekte',
            'name' => 'projekte',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Projekte hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_projekt_bild',
                    'label' => 'Bild',
                    'name' => 'bild',
                    'type' => 'image',
                    'required' => 0,
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_projekt_titel',
                    'label' => 'Titel',
                    'name' => 'titel',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_projekt_beschreibung',
                    'label' => 'Beschreibung',
                    'name' => 'beschreibung',
                    'type' => 'textarea',
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
                'value' => 'acf/projekt-scroller',
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
