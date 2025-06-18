<?php
// ACF-Felddefinition für den Zeitstrahl Icons-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_zeitstrahl_icons',
        'title' => 'Zeitstrahl Icons',
        'fields' => array(
            array(
                'key' => 'field_eintraege',
                'label' => 'Einträge',
                'name' => 'eintraege',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_icon',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_text',
                        'label' => 'Text',
                        'name' => 'text',
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
                    'value' => 'acf/zeitstrahl-icons',
                ),
            ),
        ),
    ));
}
