<?php
/**
 * ACF Felder für Vorlese-Block
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_vorlese_block',
    'title' => 'Vorlese-Block',
    'fields' => array(
        array(
            'key' => 'field_vorlese_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für den Block',
            'required' => 0,
        ),
        array(
            'key' => 'field_vorlese_text',
            'label' => 'Text',
            'name' => 'text',
            'type' => 'textarea',
            'instructions' => 'Text, der vorgelesen werden soll',
            'required' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/vorlese-block',
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
