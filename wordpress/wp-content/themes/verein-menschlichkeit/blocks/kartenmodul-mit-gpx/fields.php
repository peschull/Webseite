<?php
/**
 * ACF Felder für das Kartenmodul mit GPX
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_kartenmodul_mit_gpx',
    'title' => 'Kartenmodul mit GPX',
    'fields' => array(
        array(
            'key' => 'field_kartenmodul_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für das Kartenmodul',
            'required' => 0,
        ),
        array(
            'key' => 'field_gpx_datei',
            'label' => 'GPX-Datei',
            'name' => 'gpx_datei',
            'type' => 'file',
            'instructions' => 'Laden Sie eine GPX-Datei hoch',
            'required' => 1,
            'return_format' => 'array',
            'library' => 'all',
            'mime_types' => 'gpx',
        ),
        array(
            'key' => 'field_marker',
            'label' => 'Marker',
            'name' => 'marker',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Marker zur Karte hinzu',
            'required' => 0,
            'min' => 0,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_marker_titel',
                    'label' => 'Titel',
                    'name' => 'titel',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_marker_beschreibung',
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
                'value' => 'acf/kartenmodul-mit-gpx',
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
