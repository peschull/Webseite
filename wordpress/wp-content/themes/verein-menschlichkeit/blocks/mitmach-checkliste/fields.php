<?php
/**
 * ACF Felder für Mitmach-Checkliste
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_mitmach_checkliste',
    'title' => 'Mitmach-Checkliste',
    'fields' => array(
        array(
            'key' => 'field_checkliste_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für die Checkliste',
            'required' => 0,
        ),
        array(
            'key' => 'field_aufgaben',
            'label' => 'Aufgaben',
            'name' => 'aufgaben',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Aufgaben hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_aufgabe_text',
                    'label' => 'Aufgabe',
                    'name' => 'text',
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
                'value' => 'acf/mitmach-checkliste',
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
