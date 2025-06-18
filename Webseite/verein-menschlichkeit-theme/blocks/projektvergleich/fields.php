<?php
// fields.php für projektvergleich Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_projektvergleich',
    'title' => 'Projektvergleich Felder',
    'fields' => array(
        array(
            'key' => 'field_vergleich_titel',
            'label' => 'Vergleich Titel',
            'name' => 'vergleich_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_projekte_vergleich',
            'label' => 'Projekte Vergleich',
            'name' => 'projekte_vergleich',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_projekt_name',
                    'label' => 'Projektname',
                    'name' => 'projektname',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_projekt_wert',
                    'label' => 'Wert',
                    'name' => 'wert',
                    'type' => 'number',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/projektvergleich',
            ),
        ),
    ),
));
endif;
