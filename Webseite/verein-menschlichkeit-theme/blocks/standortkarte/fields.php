<?php
/**
 * ACF Felder für den Standortkarte-Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_standortkarte',
    'title' => 'Standortkarte Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_location',
            'label' => 'Standort',
            'name' => 'location',
            'type' => 'google_map',
            'required' => 1,
        ),
        array(
            'key' => 'field_zoom_level',
            'label' => 'Zoom-Level',
            'name' => 'zoom_level',
            'type' => 'number',
            'default_value' => 13,
            'min' => 1,
            'max' => 20,
        ),
        array(
            'key' => 'field_show_address',
            'label' => 'Adresse anzeigen',
            'name' => 'show_address',
            'type' => 'true_false',
            'default_value' => 1,
        ),
        array(
            'key' => 'field_location_name',
            'label' => 'Standortname',
            'name' => 'location_name',
            'type' => 'text',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_show_address',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_address',
            'label' => 'Adresse',
            'name' => 'address',
            'type' => 'textarea',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_show_address',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/standortkarte',
            ),
        ),
    ),
));

endif;
