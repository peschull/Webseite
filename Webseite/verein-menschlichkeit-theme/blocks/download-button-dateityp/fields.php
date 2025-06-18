<?php
/**
 * ACF Felder für Download-Button mit Dateityp
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_download_button_dateityp',
    'title' => 'Download Button Dateityp',
    'fields' => array(
        array(
            'key' => 'field_download_label',
            'label' => 'Button-Text',
            'name' => 'label',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_download_file',
            'label' => 'Datei',
            'name' => 'file',
            'type' => 'file',
            'return_format' => 'url',
            'required' => 1,
        ),
        array(
            'key' => 'field_download_type',
            'label' => 'Dateityp',
            'name' => 'type',
            'type' => 'text',
            'instructions' => 'z.B. PDF, DOCX, ZIP',
            'required' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/download-button-dateityp',
            ),
        ),
    ),
));

endif;
