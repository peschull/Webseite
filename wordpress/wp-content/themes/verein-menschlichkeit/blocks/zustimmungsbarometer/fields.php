<?php
// ACF-Felddefinition für den Zustimmungsbarometer-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_zustimmungsbarometer',
        'title' => 'Zustimmungsbarometer',
        'fields' => array(
            array(
                'key' => 'field_zustimmung',
                'label' => 'Zustimmung',
                'name' => 'zustimmung',
                'type' => 'number',
            ),
            array(
                'key' => 'field_gesamt',
                'label' => 'Gesamt',
                'name' => 'gesamt',
                'type' => 'number',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/zustimmungsbarometer',
                ),
            ),
        ),
    ));
}
