<?php
// ACF-Felddefinition für den Zwei-Spalten-Zitat-Bild-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_zwei_spalten_zitat_bild',
        'title' => 'Zwei-Spalten-Zitat-Bild',
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
            array(
                'key' => 'field_bild',
                'label' => 'Bild',
                'name' => 'bild',
                'type' => 'image',
                'return_format' => 'array',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/zwei-spalten-zitat-bild',
                ),
            ),
        ),
    ));
}
