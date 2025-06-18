<?php
// ACF-Felddefinition für den Wichtige Zahlen 2024-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_wichtige_zahlen_2024',
        'title' => 'Wichtige Zahlen 2024',
        'fields' => array(
            array(
                'key' => 'field_zahlen',
                'label' => 'Zahlen',
                'name' => 'zahlen',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wert',
                        'label' => 'Wert',
                        'name' => 'wert',
                        'type' => 'number',
                    ),
                    array(
                        'key' => 'field_beschreibung',
                        'label' => 'Beschreibung',
                        'name' => 'beschreibung',
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
                    'value' => 'acf/wichtige-zahlen-2024',
                ),
            ),
        ),
    ));
}
