<?php
/**
 * ACF Felder für Downloadbereich mit Vorschau und Filter
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_downloadbereich_vorschau_filter',
    'title' => 'Downloadbereich Vorschau Filter',
    'fields' => array(
        array(
            'key' => 'field_downloads',
            'label' => 'Downloads',
            'name' => 'downloads',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_download_titel',
                    'label' => 'Titel',
                    'name' => 'titel',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_download_file',
                    'label' => 'Datei',
                    'name' => 'file',
                    'type' => 'file',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_download_vorschau',
                    'label' => 'Vorschau-Bild',
                    'name' => 'vorschau',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_download_kategorie',
                    'label' => 'Kategorie',
                    'name' => 'kategorie',
                    'type' => 'text',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/downloadbereich-vorschau-filter',
            ),
        ),
    ),
));

endif;
