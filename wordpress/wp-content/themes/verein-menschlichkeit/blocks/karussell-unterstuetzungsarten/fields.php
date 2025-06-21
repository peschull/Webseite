<?php
// fields.php für karussell-unterstuetzungsarten Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_karussell_unterstuetzungsarten',
    'title' => 'Karussell Unterstützungsarten Felder',
    'fields' => array(
        array(
            'key' => 'field_karussell_titel',
            'label' => 'Karussell Titel',
            'name' => 'karussell_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_unterstuetzungsarten',
            'label' => 'Unterstützungsarten',
            'name' => 'unterstuetzungsarten',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_unterstuetzungsart_name',
                    'label' => 'Name',
                    'name' => 'name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_unterstuetzungsart_icon',
                    'label' => 'Icon',
                    'name' => 'icon',
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
                'value' => 'acf/karussell-unterstuetzungsarten',
            ),
        ),
    ),
));
endif;
