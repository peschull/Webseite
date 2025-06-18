<?php
/**
 * ACF Felder für die Zitate-Mauer
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_zitate_mauer',
    'title' => 'Zitate-Mauer',
    'fields' => array(
        array(
            'key' => 'field_zitate_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für die Zitate-Mauer',
            'required' => 0,
        ),
        array(
            'key' => 'field_zitate',
            'label' => 'Zitate',
            'name' => 'zitate',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Zitate hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_zitat_text',
                    'label' => 'Zitat',
                    'name' => 'text',
                    'type' => 'textarea',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_zitat_autor',
                    'label' => 'Autor',
                    'name' => 'autor',
                    'type' => 'text',
                    'required' => 0,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/zitate-mauer',
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
