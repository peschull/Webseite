<?php
/**
 * ACF Felder für Button Row Farbverlauf
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_button_row_farbverlauf',
    'title' => 'Button Row Farbverlauf',
    'fields' => array(
        array(
            'key' => 'field_buttons',
            'label' => 'Buttons',
            'name' => 'buttons',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Buttons hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_button_text',
                    'label' => 'Button Text',
                    'name' => 'text',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_button_link',
                    'label' => 'Button Link',
                    'name' => 'link',
                    'type' => 'url',
                    'required' => 1,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/button-row-farbverlauf',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
));

endif;
