<?php
// ACF-Felddefinition für den Was uns antreibt Slider-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_was_uns_antreibt_slider',
        'title' => 'Was uns antreibt Slider',
        'fields' => array(
            array(
                'key' => 'field_slides',
                'label' => 'Slides',
                'name' => 'slides',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_spruch',
                        'label' => 'Spruch',
                        'name' => 'spruch',
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
                    'value' => 'acf/was_uns_antreibt_slider',
                ),
            ),
        ),
    ));
}
