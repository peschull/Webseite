<?php
// ACF-Felddefinition für den Mitgliederkarte-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_mitgliederkarte',
        'title' => 'Mitgliederkarte',
        'fields' => array(
            array(
                'key' => 'field_karte',
                'label' => 'Karte',
                'name' => 'karte',
                'type' => 'textarea',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/mitgliederkarte',
                ),
            ),
        ),
    ));
}
