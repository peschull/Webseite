<?php
/**
 * ACF Felder für Countdown Timer
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_countdown_timer',
    'title' => 'Countdown Timer',
    'fields' => array(
        array(
            'key' => 'field_countdown_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für den Countdown',
            'required' => 0,
        ),
        array(
            'key' => 'field_countdown_datum',
            'label' => 'Zieldatum',
            'name' => 'datum',
            'type' => 'date_time_picker',
            'instructions' => 'Wählen Sie das Zieldatum und die Uhrzeit',
            'required' => 1,
            'display_format' => 'd.m.Y H:i',
            'return_format' => 'Y-m-d H:i:s',
            'first_day' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/countdown-timer',
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
