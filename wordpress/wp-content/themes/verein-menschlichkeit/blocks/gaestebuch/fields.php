<?php
// ACF-Felddefinition für den Gästebuch-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_gaestebuch',
        'title' => 'Gästebuch',
        'fields' => array(
            array(
                'key' => 'field_eintraege',
                'label' => 'Einträge',
                'name' => 'eintraege',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_eintrag_text',
                        'label' => 'Eintrag',
                        'name' => 'eintrag',
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
                    'value' => 'acf/gaestebuch',
                ),
            ),
        ),
    ));
}
