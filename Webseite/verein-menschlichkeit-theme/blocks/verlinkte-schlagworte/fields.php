<?php
/**
 * ACF Felder für den Verlinkte-Schlagworte Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_verlinkte_schlagworte',
    'title' => 'Verlinkte Schlagworte Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_title',
            'label' => 'Überschrift',
            'name' => 'title',
            'type' => 'text',
            'instructions' => 'Optional: Eine Überschrift über den Schlagworten.',
        ),
        array(
            'key' => 'field_tags',
            'label' => 'Schlagworte',
            'name' => 'tags',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Schlagwort hinzufügen',
            'sub_fields' => array(
                array(
                    'key' => 'field_tag_label',
                    'label' => 'Bezeichnung',
                    'name' => 'label',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_tag_link',
                    'label' => 'Link',
                    'name' => 'link',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_tag_count',
                    'label' => 'Anzahl',
                    'name' => 'count',
                    'type' => 'number',
                    'min' => 0,
                ),
            ),
        ),
        array(
            'key' => 'field_tag_style',
            'label' => 'Tag-Stil',
            'name' => 'tag_style',
            'type' => 'select',
            'choices' => array(
                'default' => 'Standard',
                'solid' => 'Ausgefüllt',
                'outline' => 'Umrandet',
            ),
            'default_value' => 'default',
        ),
        array(
            'key' => 'field_tag_size',
            'label' => 'Tag-Größe',
            'name' => 'tag_size',
            'type' => 'select',
            'choices' => array(
                'small' => 'Klein',
                'medium' => 'Mittel',
                'large' => 'Groß',
            ),
            'default_value' => 'medium',
        ),
        array(
            'key' => 'field_show_count',
            'label' => 'Anzahl anzeigen',
            'name' => 'show_count',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 1,
        ),
        array(
            'key' => 'field_show_more_button',
            'label' => '"Mehr anzeigen" Button',
            'name' => 'show_more_button',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 0,
        ),
        array(
            'key' => 'field_initial_show',
            'label' => 'Anfangs angezeigte Tags',
            'name' => 'initial_show',
            'type' => 'number',
            'default_value' => 10,
            'min' => 1,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_show_more_button',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/verlinkte-schlagworte',
            ),
        ),
    ),
));

endif;
