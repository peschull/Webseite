<?php
// fields.php für jahresrueckblick-bildstrecke Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_jahresrueckblick_bildstrecke',
    'title' => 'Jahresrückblick Bildstrecke Felder',
    'fields' => array(
        array(
            'key' => 'field_bildstrecke_titel',
            'label' => 'Bildstrecke Titel',
            'name' => 'bildstrecke_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_bildstrecke_inhalte',
            'label' => 'Bildstrecke Inhalte',
            'name' => 'bildstrecke_inhalte',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_bild',
                    'label' => 'Bild',
                    'name' => 'bild',
                    'type' => 'image',
                ),
                array(
                    'key' => 'field_bild_beschreibung',
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
                'value' => 'acf/jahresrueckblick-bildstrecke',
            ),
        ),
    ),
));
endif;
