<?php
// ACF-Felddefinition für den Vorstandswahlmodul-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_vorstandswahlmodul',
        'title' => 'Vorstandswahlmodul',
        'fields' => array(
            array(
                'key' => 'field_wahl',
                'label' => 'Wahl',
                'name' => 'wahl',
                'type' => 'textarea',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/vorstandswahlmodul',
                ),
            ),
        ),
    ));
}
