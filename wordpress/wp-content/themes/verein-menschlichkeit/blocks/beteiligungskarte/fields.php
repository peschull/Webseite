<?php
// fields.php für beteiligungskarte Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_beteiligungskarte',
    'title' => 'Beteiligungskarte Felder',
    'fields' => array(
        array(
            'key' => 'field_karte_titel',
            'label' => 'Karte Titel',
            'name' => 'karte_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_karte_content',
            'label' => 'Karteninhalt',
            'name' => 'karte_content',
            'type' => 'textarea',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/beteiligungskarte',
            ),
        ),
    ),
));
endif;
