<?php
/**
 * ACF Felder für den Live-Feedback-Button Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_live_feedback_button',
    'title' => 'Live-Feedback-Button Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_button_text',
            'label' => 'Button-Text',
            'name' => 'button_text',
            'type' => 'text',
            'default_value' => 'Feedback geben',
        ),
        array(
            'key' => 'field_feedback_options',
            'label' => 'Feedback-Optionen',
            'name' => 'feedback_options',
            'type' => 'repeater',
            'layout' => 'table',
            'min' => 1,
            'button_label' => 'Option hinzufügen',
            'sub_fields' => array(
                array(
                    'key' => 'field_option_label',
                    'label' => 'Beschriftung',
                    'name' => 'label',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_option_value',
                    'label' => 'Wert',
                    'name' => 'value',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_option_icon',
                    'label' => 'Icon (Emoji)',
                    'name' => 'icon',
                    'type' => 'text',
                    'instructions' => 'Ein Emoji als Icon für diese Option',
                ),
            ),
        ),
        array(
            'key' => 'field_allow_comments',
            'label' => 'Kommentare erlauben',
            'name' => 'allow_comments',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/live-feedback-button',
            ),
        ),
    ),
));

endif;
