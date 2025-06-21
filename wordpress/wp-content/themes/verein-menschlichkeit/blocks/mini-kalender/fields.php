<?php
// fields.php für mini-kalender Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_mini_kalender',
    'title' => 'Mini Kalender Felder',
    'fields' => array(
        array(
            'key' => 'field_kalender_titel',
            'label' => 'Kalender Titel',
            'name' => 'kalender_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_kalender_daten',
            'label' => 'Kalenderdaten',
            'name' => 'kalender_daten',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_kalender_datum',
                    'label' => 'Datum',
                    'name' => 'datum',
                    'type' => 'date_picker',
                ),
                array(
                    'key' => 'field_kalender_beschreibung',
                    'label' => 'Beschreibung',
                    'name' => 'beschreibung',
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
                'value' => 'acf/mini-kalender',
            ),
        ),
    ),
));
endif;
