<?php
/**
 * ACF Felder für den Spendenfortschritt Animiert Block
 */

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_spendenfortschritt',
        'title' => 'Spendenfortschritt Animiert',
        'fields' => array(
            array(
                'key' => 'field_title',
                'label' => 'Überschrift',
                'name' => 'title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_description',
                'label' => 'Beschreibung',
                'name' => 'description',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            array(
                'key' => 'field_current_amount',
                'label' => 'Aktueller Betrag',
                'name' => 'current_amount',
                'type' => 'number',
                'required' => 1,
                'min' => 0,
            ),
            array(
                'key' => 'field_target_amount',
                'label' => 'Zielbetrag',
                'name' => 'target_amount',
                'type' => 'number',
                'required' => 1,
                'min' => 1,
            ),
            array(
                'key' => 'field_currency',
                'label' => 'Währung',
                'name' => 'currency',
                'type' => 'text',
                'default_value' => '€',
            ),
            array(
                'key' => 'field_display_style',
                'label' => 'Darstellungsart',
                'name' => 'display_style',
                'type' => 'select',
                'choices' => array(
                    'bar' => 'Fortschrittsbalken',
                    'circle' => 'Kreisdiagramm',
                ),
                'default_value' => 'bar',
            ),
            array(
                'key' => 'field_color_scheme',
                'label' => 'Farbschema',
                'name' => 'color_scheme',
                'type' => 'select',
                'choices' => array(
                    'green' => 'Grün',
                    'blue' => 'Blau',
                    'orange' => 'Orange',
                    'purple' => 'Violett',
                ),
                'default_value' => 'green',
            ),
            array(
                'key' => 'field_show_details',
                'label' => 'Details anzeigen',
                'name' => 'show_details',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_animation_duration',
                'label' => 'Animationsdauer (ms)',
                'name' => 'animation_duration',
                'type' => 'number',
                'default_value' => 1500,
                'min' => 500,
                'max' => 3000,
                'step' => 100,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/spendenfortschritt-animiert',
                ),
            ),
        ),
    ));
}
