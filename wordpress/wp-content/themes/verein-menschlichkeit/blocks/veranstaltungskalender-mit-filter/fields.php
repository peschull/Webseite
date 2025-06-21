<?php
/**
 * ACF Felder für den Veranstaltungskalender mit Filter Block
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_veranstaltungskalender_mit_filter',
    'title' => 'Veranstaltungskalender mit Filter',
    'fields' => array(
        array(
            'key' => 'field_kalender_titel',
            'label' => 'Kalender Titel',
            'name' => 'kalender_titel',
            'type' => 'text',
            'instructions' => 'Geben Sie einen Titel für den Kalender ein',
            'required' => 0,
            'default_value' => 'Unsere Veranstaltungen',
        ),
        array(
            'key' => 'field_filter_kategorien',
            'label' => 'Filter Kategorien',
            'name' => 'filter_kategorien',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Filter-Kategorien hinzu',
            'required' => 0,
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'sub_fields' => array(
                array(
                    'key' => 'field_kategorie_label',
                    'label' => 'Kategorie Name',
                    'name' => 'label',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_kategorie_value',
                    'label' => 'Kategorie Wert',
                    'name' => 'value',
                    'type' => 'text',
                    'required' => 1,
                ),
            ),
        ),
        array(
            'key' => 'field_anzahl_events',
            'label' => 'Anzahl Events pro Seite',
            'name' => 'anzahl_events',
            'type' => 'number',
            'instructions' => 'Wie viele Events sollen pro Seite angezeigt werden?',
            'required' => 0,
            'default_value' => 12,
            'min' => 1,
            'max' => 100,
            'step' => 1,
        ),
        array(
            'key' => 'field_ansicht',
            'label' => 'Standard-Ansicht',
            'name' => 'ansicht',
            'type' => 'select',
            'instructions' => 'Wählen Sie die Standard-Ansicht für den Kalender',
            'required' => 0,
            'choices' => array(
                'list' => 'Liste',
                'grid' => 'Kacheln',
                'kalender' => 'Kalender',
            ),
            'default_value' => 'list',
            'return_format' => 'value',
            'multiple' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/veranstaltungskalender-mit-filter',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
));

endif;
