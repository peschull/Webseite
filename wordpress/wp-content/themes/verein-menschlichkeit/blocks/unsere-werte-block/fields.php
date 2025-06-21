<?php
/**
 * ACF Felder für den Unsere Werte Block
 */

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_werte_block',
        'title' => 'Unsere Werte Block',
        'fields' => array(
            array(
                'key' => 'field_heading',
                'label' => 'Überschrift',
                'name' => 'heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_subheading',
                'label' => 'Unterüberschrift',
                'name' => 'subheading',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            array(
                'key' => 'field_layout_style',
                'label' => 'Layout-Stil',
                'name' => 'layout_style',
                'type' => 'select',
                'choices' => array(
                    'grid' => 'Grid (Standard)',
                    'list' => 'Liste',
                    'carousel' => 'Carousel',
                ),
                'default_value' => 'grid',
            ),
            array(
                'key' => 'field_animation_style',
                'label' => 'Animations-Stil',
                'name' => 'animation_style',
                'type' => 'select',
                'choices' => array(
                    'fade' => 'Einblenden',
                    'slide' => 'Slide von unten',
                    'scale' => 'Skalieren',
                    'none' => 'Keine Animation',
                ),
                'default_value' => 'fade',
            ),
            array(
                'key' => 'field_values',
                'label' => 'Werte',
                'name' => 'values',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Wert hinzufügen',
                'sub_fields' => array(
                    array(
                        'key' => 'field_icon',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'group',
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_icon_type',
                                'label' => 'Icon-Typ',
                                'name' => 'type',
                                'type' => 'select',
                                'choices' => array(
                                    'font_awesome' => 'Font Awesome Icon',
                                    'custom' => 'Eigenes Icon',
                                ),
                                'default_value' => 'font_awesome',
                            ),
                            array(
                                'key' => 'field_font_awesome_icon',
                                'label' => 'Font Awesome Icon',
                                'name' => 'font_awesome_icon',
                                'type' => 'text',
                                'instructions' => 'Geben Sie die Font Awesome Klasse ein (z.B. fas fa-heart)',
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_icon_type',
                                            'operator' => '==',
                                            'value' => 'font_awesome',
                                        ),
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_custom_icon',
                                'label' => 'Eigenes Icon',
                                'name' => 'custom_icon',
                                'type' => 'image',
                                'return_format' => 'array',
                                'preview_size' => 'thumbnail',
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_icon_type',
                                            'operator' => '==',
                                            'value' => 'custom',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_title',
                        'label' => 'Titel',
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_description',
                        'label' => 'Beschreibung',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 4,
                    ),
                    array(
                        'key' => 'field_link',
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/unsere-werte-block',
                ),
            ),
        ),
    ));
}
