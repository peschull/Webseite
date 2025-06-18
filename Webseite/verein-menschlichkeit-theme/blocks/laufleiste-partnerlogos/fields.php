<?php
// ACF-Felddefinition für den Laufleiste Partnerlogos-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_laufleiste_partnerlogos',
        'title' => 'Laufleiste Partnerlogos',
        'fields' => array(
            array(
                'key' => 'field_logos',
                'label' => 'Logos',
                'name' => 'logos',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_logo_url',
                        'label' => 'Logo URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                    array(
                        'key' => 'field_logo_alt',
                        'label' => 'Alt-Text',
                        'name' => 'alt',
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
                    'value' => 'acf/laufleiste-partnerlogos',
                ),
            ),
        ),
    ));
}
