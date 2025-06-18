<?php
/**
 * ACF Felder für Downloadbereich
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_downloadbereich',
    'title' => 'Downloadbereich',
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
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/downloadbereich',
            ),
        ),
    ),
));

endif;
