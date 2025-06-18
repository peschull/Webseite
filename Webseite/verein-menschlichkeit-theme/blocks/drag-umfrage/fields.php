<?php
/**
 * ACF Felder für Drag-Umfrage
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_drag_umfrage',
    'title' => 'Drag Umfrage',
    'fields' => array(
        array(
            'key' => 'field_drag_items',
            'label' => 'Drag-Elemente',
            'name' => 'drag_items',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_drag_item_text',
                    'label' => 'Text',
                    'name' => 'text',
                    'type' => 'text',
                ),
            ),
        ),
        array(
            'key' => 'field_drop_zones',
            'label' => 'Drop-Zonen',
            'name' => 'drop_zones',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_drop_zone_label',
                    'label' => 'Label',
                    'name' => 'label',
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
                'value' => 'acf/drag-umfrage',
            ),
        ),
    ),
));

endif;
