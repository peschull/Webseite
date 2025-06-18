<?php
/**
 * ACF Felder für Dokumentensammlung
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_dokumentensammlung',
    'title' => 'Dokumentensammlung',
    'fields' => array(
        array(
            'key' => 'field_dokumente',
            'label' => 'Dokumente',
            'name' => 'dokumente',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_dokument_titel',
                    'label' => 'Titel',
                    'name' => 'titel',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_dokument_file',
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
                'value' => 'acf/dokumentensammlung',
            ),
        ),
    ),
));

endif;
