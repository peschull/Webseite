<?php
// fields.php für live-events-mini-ticker Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_live_events_mini_ticker',
    'title' => 'Live Events Mini Ticker Felder',
    'fields' => array(
        array(
            'key' => 'field_ticker_titel',
            'label' => 'Ticker Titel',
            'name' => 'ticker_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_ticker_inhalte',
            'label' => 'Ticker Inhalte',
            'name' => 'ticker_inhalte',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_ticker_text',
                    'label' => 'Text',
                    'name' => 'text',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_ticker_zeit',
                    'label' => 'Zeit',
                    'name' => 'zeit',
                    'type' => 'time_picker',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/live-events-mini-ticker',
            ),
        ),
    ),
));
endif;
