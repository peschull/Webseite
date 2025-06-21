<?php
/**
 * ACF Felder für Reaktions-Block
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_reaktions_block',
    'title' => 'Reaktions-Block',
    'fields' => array(
        array(
            'key' => 'field_reaktions_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für den Reaktionsblock',
            'required' => 0,
        ),
        array(
            'key' => 'field_emojis',
            'label' => 'Emojis',
            'name' => 'emojis',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Emojis hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_emoji_zeichen',
                    'label' => 'Emoji',
                    'name' => 'zeichen',
                    'type' => 'text',
                    'required' => 1,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/reaktions-block',
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
