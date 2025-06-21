<?php
/**
 * ACF Felder für Drag-Kategorisierung
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_drag_kategorisierung',
    'title' => 'Drag Kategorisierung',
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
            'key' => 'field_categories',
            'label' => 'Kategorien',
            'name' => 'categories',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_category_name',
                    'label' => 'Kategorie-Name',
                    'name' => 'name',
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
                'value' => 'acf/drag-kategorisierung',
            ),
        ),
    ),
));

endif;
