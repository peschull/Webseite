<?php
/**
 * ACF Felder für den Timeline Meilensteine Block
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_timeline_meilensteine',
    'title' => 'Timeline Meilensteine',
    'fields' => array(
        array(
            'key' => 'field_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für die Timeline',
            'required' => 0,
        ),
        array(
            'key' => 'field_meilensteine',
            'label' => 'Meilensteine',
            'name' => 'meilensteine',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Meilensteine zur Timeline hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_meilenstein_datum',
                    'label' => 'Datum',
                    'name' => 'datum',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_meilenstein_titel',
                    'label' => 'Meilenstein Titel',
                    'name' => 'titel',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_meilenstein_beschreibung',
                    'label' => 'Beschreibung',
                    'name' => 'beschreibung',
                    'type' => 'textarea',
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
                'value' => 'acf/timeline-meilensteine',
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
