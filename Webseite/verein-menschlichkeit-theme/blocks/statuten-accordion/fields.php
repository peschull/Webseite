<?php
// ACF-Felddefinition für den Statuten Accordion-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_statuten_accordion',
        'title' => 'Statuten Accordion',
        'fields' => array(
            array(
                'key' => 'field_statuten',
                'label' => 'Statuten',
                'name' => 'statuten',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_titel',
                        'label' => 'Titel',
                        'name' => 'titel',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_text',
                        'label' => 'Text',
                        'name' => 'text',
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
                    'value' => 'acf/statuten-accordion',
                ),
            ),
        ),
    ));
}
