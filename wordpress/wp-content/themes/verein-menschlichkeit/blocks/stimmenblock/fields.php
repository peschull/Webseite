<?php
// ACF-Felddefinition für den Stimmenblock-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_stimmenblock',
        'title' => 'Stimmenblock',
        'fields' => array(
            array(
                'key' => 'field_stimmen',
                'label' => 'Stimmen',
                'name' => 'stimmen',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_text',
                        'label' => 'Text',
                        'name' => 'text',
                        'type' => 'textarea',
                    ),
                    array(
                        'key' => 'field_autor',
                        'label' => 'Autor',
                        'name' => 'autor',
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
                    'value' => 'acf/stimmenblock',
                ),
            ),
        ),
    ));
}
