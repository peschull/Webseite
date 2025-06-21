<?php
/**
 * ACF Felder für Statistikblock animiert
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_statistikblock_animiert',
    'title' => 'Statistikblock animiert',
    'fields' => array(
        array(
            'key' => 'field_statistikblock_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für den Statistikblock',
            'required' => 0,
        ),
        array(
            'key' => 'field_statistiken',
            'label' => 'Statistiken',
            'name' => 'statistiken',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Statistiken hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_stat_zahl',
                    'label' => 'Zahl',
                    'name' => 'zahl',
                    'type' => 'number',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_stat_label',
                    'label' => 'Label',
                    'name' => 'label',
                    'type' => 'text',
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
                'value' => 'acf/statistikblock-animiert',
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
