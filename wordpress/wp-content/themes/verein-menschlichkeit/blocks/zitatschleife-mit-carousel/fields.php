<?php
/**
 * ACF Felder für die Zitatschleife mit Carousel
 */

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_quote_carousel',
        'title' => 'Zitatschleife mit Carousel',
        'fields' => array(
            array(
                'key' => 'field_quotes',
                'label' => 'Zitate',
                'name' => 'quotes',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Zitat hinzufügen',
                'sub_fields' => array(
                    array(
                        'key' => 'field_quote_text',
                        'label' => 'Zitat',
                        'name' => 'quote_text',
                        'type' => 'textarea',
                        'rows' => 4,
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_author',
                        'label' => 'Autor',
                        'name' => 'author',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_role',
                        'label' => 'Position/Rolle',
                        'name' => 'role',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_author_image',
                        'label' => 'Autor Bild',
                        'name' => 'author_image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                    ),
                ),
            ),
            array(
                'key' => 'field_auto_play',
                'label' => 'Automatisch abspielen',
                'name' => 'auto_play',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_auto_play_speed',
                'label' => 'Abspielgeschwindigkeit (ms)',
                'name' => 'auto_play_speed',
                'type' => 'number',
                'default_value' => 5000,
                'min' => 2000,
                'max' => 10000,
                'step' => 500,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_auto_play',
                            'operator' => '==',
                            'value' => 1,
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_show_navigation',
                'label' => 'Navigationspfeile anzeigen',
                'name' => 'show_navigation',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_show_dots',
                'label' => 'Punktenavigation anzeigen',
                'name' => 'show_dots',
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
                    'value' => 'acf/zitatschleife-mit-carousel',
                ),
            ),
        ),
    ));
}
