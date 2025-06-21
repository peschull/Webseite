<?php
// fields.php für event-box Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_event_box',
    'title' => 'Event Box Felder',
    'fields' => array(
        array(
            'key' => 'field_event_titel',
            'label' => 'Event Titel',
            'name' => 'event_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_event_beschreibung',
            'label' => 'Event Beschreibung',
            'name' => 'event_beschreibung',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_event_datum',
            'label' => 'Event Datum',
            'name' => 'event_datum',
            'type' => 'date_picker',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/event-box',
            ),
        ),
    ),
));
endif;
