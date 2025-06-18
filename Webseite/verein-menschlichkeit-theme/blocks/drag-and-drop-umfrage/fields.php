<?php
// fields.php für drag-and-drop-umfrage Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_drag_and_drop_umfrage',
    'title' => 'Drag & Drop Umfrage Felder',
    'fields' => array(
        array(
            'key' => 'field_umfrage_frage',
            'label' => 'Umfrage-Frage',
            'name' => 'umfrage_frage',
            'type' => 'text',
        ),
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
                'value' => 'acf/drag-and-drop-umfrage',
            ),
        ),
    ),
));
endif;
