<?php
/**
 * ACF Felder für Ehrenamtliche Übersicht
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_ehrenamtliche_uebersicht',
    'title' => 'Ehrenamtliche Übersicht',
    'fields' => array(
        array(
            'key' => 'field_ehrenamtliche',
            'label' => 'Ehrenamtliche',
            'name' => 'ehrenamtliche',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_ehrenamtlicher_name',
                    'label' => 'Name',
                    'name' => 'name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_ehrenamtlicher_rolle',
                    'label' => 'Rolle',
                    'name' => 'rolle',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_ehrenamtlicher_bild',
                    'label' => 'Bild',
                    'name' => 'bild',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/ehrenamtliche-uebersicht',
            ),
        ),
    ),
));

endif;
