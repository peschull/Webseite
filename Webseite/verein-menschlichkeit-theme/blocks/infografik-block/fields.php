<?php
/**
 * ACF Felder für den Infografik Block
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_infografik_block',
    'title' => 'Infografik Block',
    'fields' => array(
        array(
            'key' => 'field_infografik_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für die Infografik',
            'required' => 0,
        ),
        array(
            'key' => 'field_infografik',
            'label' => 'Infografik',
            'name' => 'infografik',
            'type' => 'image',
            'instructions' => 'Fügen Sie eine Grafik hinzu',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),
        array(
            'key' => 'field_text_oben',
            'label' => 'Text oben',
            'name' => 'text_oben',
            'type' => 'textarea',
            'instructions' => 'Optionaler Text oberhalb der Grafik',
            'required' => 0,
        ),
        array(
            'key' => 'field_text_unten',
            'label' => 'Text unten',
            'name' => 'text_unten',
            'type' => 'textarea',
            'instructions' => 'Optionaler Text unterhalb der Grafik',
            'required' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/infografik-block',
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
