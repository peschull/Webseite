<?php
/**
 * ACF Felder für den Parallax-Header Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_parallax_header',
    'title' => 'Parallax-Header Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_background_image',
            'label' => 'Hintergrundbild',
            'name' => 'background_image',
            'type' => 'image',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'large',
            'instructions' => 'Wählen Sie ein hochauflösendes Bild (mindestens 1920px breit).',
        ),
        array(
            'key' => 'field_overlay_opacity',
            'label' => 'Overlay-Transparenz',
            'name' => 'overlay_opacity',
            'type' => 'range',
            'min' => 0,
            'max' => 1,
            'step' => 0.1,
            'default_value' => 0.3,
            'instructions' => 'Stellen Sie die Transparenz der dunklen Überlagerung ein.',
        ),
        array(
            'key' => 'field_heading',
            'label' => 'Überschrift',
            'name' => 'heading',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_subheading',
            'label' => 'Unterüberschrift',
            'name' => 'subheading',
            'type' => 'textarea',
            'rows' => 2,
        ),
        array(
            'key' => 'field_text_color',
            'label' => 'Text-Farbe',
            'name' => 'text_color',
            'type' => 'select',
            'choices' => array(
                'light' => 'Hell',
                'dark' => 'Dunkel',
            ),
            'default_value' => 'light',
        ),
        array(
            'key' => 'field_parallax_speed',
            'label' => 'Parallax-Geschwindigkeit',
            'name' => 'parallax_speed',
            'type' => 'range',
            'min' => 0,
            'max' => 1,
            'step' => 0.1,
            'default_value' => 0.5,
        ),
        array(
            'key' => 'field_min_height',
            'label' => 'Mindesthöhe',
            'name' => 'min_height',
            'type' => 'number',
            'default_value' => 500,
            'min' => 300,
            'max' => 1000,
            'instructions' => 'Mindesthöhe des Headers in Pixeln.',
        ),
        array(
            'key' => 'field_buttons',
            'label' => 'Buttons',
            'name' => 'buttons',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Button hinzufügen',
            'sub_fields' => array(
                array(
                    'key' => 'field_button_text',
                    'label' => 'Button-Text',
                    'name' => 'button_text',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_button_link',
                    'label' => 'Button-Link',
                    'name' => 'button_link',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_button_style',
                    'label' => 'Button-Stil',
                    'name' => 'button_style',
                    'type' => 'select',
                    'choices' => array(
                        'primary' => 'Primär',
                        'secondary' => 'Sekundär',
                    ),
                    'default_value' => 'primary',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/parallax-header',
            ),
        ),
    ),
));

endif;
