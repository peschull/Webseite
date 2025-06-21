<?php
/**
 * ACF Felder für Pressebereich Downloadboxen
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_pressebereich_downloadboxen',
    'title' => 'Pressebereich Downloadboxen',
    'fields' => array(
        array(
            'key' => 'field_presse_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für den Pressebereich',
            'required' => 0,
        ),
        array(
            'key' => 'field_downloads',
            'label' => 'Downloads',
            'name' => 'downloads',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Downloadboxen hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_download_titel',
                    'label' => 'Titel',
                    'name' => 'titel',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_download_beschreibung',
                    'label' => 'Beschreibung',
                    'name' => 'beschreibung',
                    'type' => 'textarea',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_download_datei',
                    'label' => 'Datei',
                    'name' => 'datei',
                    'type' => 'file',
                    'required' => 1,
                    'return_format' => 'array',
                    'library' => 'all',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/pressebereich-downloadboxen',
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
