<?php
// fields.php für unterstuetzungslevel Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_unterstuetzungslevel',
    'title' => 'Unterstützungslevel Felder',
    'fields' => array(
        array(
            'key' => 'field_level_titel',
            'label' => 'Level Titel',
            'name' => 'level_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_level_liste',
            'label' => 'Level Liste',
            'name' => 'level_liste',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_level_name',
                    'label' => 'Level Name',
                    'name' => 'level_name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_level_beschreibung',
                    'label' => 'Beschreibung',
                    'name' => 'beschreibung',
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
                'value' => 'acf/unterstuetzungslevel',
            ),
        ),
    ),
));
endif;
