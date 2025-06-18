<?php
// fields.php für terminbuchung Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_terminbuchung',
    'title' => 'Terminbuchung Felder',
    'fields' => array(
        array(
            'key' => 'field_buchung_titel',
            'label' => 'Buchung Titel',
            'name' => 'buchung_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_buchung_formular',
            'label' => 'Buchungsformular Shortcode',
            'name' => 'buchung_formular',
            'type' => 'text',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/terminbuchung',
            ),
        ),
    ),
));
endif;
