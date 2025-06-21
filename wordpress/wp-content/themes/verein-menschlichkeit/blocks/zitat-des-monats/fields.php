<?php
// ACF-Felddefinition für den Zitat des Monats-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_zitat_des_monats',
        'title' => 'Zitat des Monats',
        'fields' => array(
            array(
                'key' => 'field_zitat',
                'label' => 'Zitat',
                'name' => 'zitat',
                'type' => 'textarea',
            ),
            array(
                'key' => 'field_autor',
                'label' => 'Autor',
                'name' => 'autor',
                'type' => 'text',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/zitat-des-monats',
                ),
            ),
        ),
    ));
}
