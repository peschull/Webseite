<?php
// fields.php für vorher-nachher-modul Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_vorher_nachher_modul',
    'title' => 'Vorher-Nachher Modul Felder',
    'fields' => array(
        array(
            'key' => 'field_vergleich_titel',
            'label' => 'Vergleich Titel',
            'name' => 'vergleich_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_bildvergleich',
            'label' => 'Bildvergleich',
            'name' => 'bildvergleich',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_bild_vorher',
                    'label' => 'Bild Vorher',
                    'name' => 'bild_vorher',
                    'type' => 'image',
                ),
                array(
                    'key' => 'field_bild_nachher',
                    'label' => 'Bild Nachher',
                    'name' => 'bild_nachher',
                    'type' => 'image',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/vorher-nachher-modul',
            ),
        ),
    ),
));
endif;
