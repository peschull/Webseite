<?php
/**
 * ACF Felder für Cookie-Wahl
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_cookie_wahl',
    'title' => 'Cookie Wahl',
    'fields' => array(
        array(
            'key' => 'field_cookie_text',
            'label' => 'Cookie Hinweistext',
            'name' => 'cookie_text',
            'type' => 'textarea',
            'required' => 1,
        ),
        array(
            'key' => 'field_cookie_options',
            'label' => 'Cookie Optionen',
            'name' => 'cookie_options',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_option_label',
                    'label' => 'Option Label',
                    'name' => 'label',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_option_value',
                    'label' => 'Option Wert',
                    'name' => 'value',
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
                'value' => 'acf/cookie-wahl',
            ),
        ),
    ),
));

endif;
