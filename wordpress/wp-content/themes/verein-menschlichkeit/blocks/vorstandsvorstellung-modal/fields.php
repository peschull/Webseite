<?php
/**
 * ACF Felder für Vorstandsvorstellung Modal
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_vorstandsvorstellung_modal',
    'title' => 'Vorstandsvorstellung Modal',
    'fields' => array(
        array(
            'key' => 'field_vorstand_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für die Vorstandsvorstellung',
            'required' => 0,
        ),
        array(
            'key' => 'field_vorstandsmitglieder',
            'label' => 'Vorstandsmitglieder',
            'name' => 'vorstandsmitglieder',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Vorstandsmitglieder hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_mitglied_name',
                    'label' => 'Name',
                    'name' => 'name',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_mitglied_funktion',
                    'label' => 'Funktion',
                    'name' => 'funktion',
                    'type' => 'text',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_mitglied_bild',
                    'label' => 'Bild',
                    'name' => 'bild',
                    'type' => 'image',
                    'required' => 0,
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_mitglied_bio',
                    'label' => 'Kurzbiografie',
                    'name' => 'bio',
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
                'value' => 'acf/vorstandsvorstellung-modal',
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
