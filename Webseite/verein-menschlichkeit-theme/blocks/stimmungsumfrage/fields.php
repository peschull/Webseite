<?php
// fields.php für stimmungsumfrage Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_stimmungsumfrage',
    'title' => 'Stimmungsumfrage Felder',
    'fields' => array(
        array(
            'key' => 'field_umfrage_titel',
            'label' => 'Umfrage Titel',
            'name' => 'umfrage_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_umfrage_fragen',
            'label' => 'Umfrage Fragen',
            'name' => 'umfrage_fragen',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_frage',
                    'label' => 'Frage',
                    'name' => 'frage',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_antworten',
                    'label' => 'Antworten',
                    'name' => 'antworten',
                    'type' => 'textarea',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/stimmungsumfrage',
            ),
        ),
    ),
));
endif;
