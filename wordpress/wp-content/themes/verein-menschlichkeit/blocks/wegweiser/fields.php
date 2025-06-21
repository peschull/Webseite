<?php
// ACF-Felddefinition für den Wegweiser-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_wegweiser',
        'title' => 'Wegweiser',
        'fields' => array(
            array(
                'key' => 'field_punkte',
                'label' => 'Punkte',
                'name' => 'punkte',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_titel',
                        'label' => 'Titel',
                        'name' => 'titel',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_beschreibung',
                        'label' => 'Beschreibung',
                        'name' => 'beschreibung',
                        'type' => 'textarea',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/wegweiser',
                ),
            ),
        ),
    ));
}
