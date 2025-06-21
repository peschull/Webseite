<?php
// fields.php für fortschrittsbaum Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_fortschrittsbaum',
    'title' => 'Fortschrittsbaum Felder',
    'fields' => array(
        array(
            'key' => 'field_baum_titel',
            'label' => 'Baum Titel',
            'name' => 'baum_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_baum_inhalte',
            'label' => 'Baum Inhalte',
            'name' => 'baum_inhalte',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_baum_knoten',
                    'label' => 'Knoten',
                    'name' => 'knoten',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_baum_status',
                    'label' => 'Status',
                    'name' => 'status',
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
                'value' => 'acf/fortschrittsbaum',
            ),
        ),
    ),
));
endif;
