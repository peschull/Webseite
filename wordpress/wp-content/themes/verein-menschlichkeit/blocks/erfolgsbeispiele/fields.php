<?php
/**
 * ACF Felder für Erfolgsbeispiele
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_erfolgsbeispiele',
    'title' => 'Erfolgsbeispiele',
    'fields' => array(
        array(
            'key' => 'field_erfolgsbeispiele',
            'label' => 'Erfolgsbeispiele',
            'name' => 'erfolgsbeispiele',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_erfolgsbeispiel_titel',
                    'label' => 'Titel',
                    'name' => 'titel',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_erfolgsbeispiel_text',
                    'label' => 'Text',
                    'name' => 'text',
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
                'value' => 'acf/erfolgsbeispiele',
            ),
        ),
    ),
));

endif;
