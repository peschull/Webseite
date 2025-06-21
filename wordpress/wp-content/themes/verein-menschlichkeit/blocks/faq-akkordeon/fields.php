<?php
/**
 * ACF Felder für den FAQ Akkordeon Block
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_faq_akkordeon',
    'title' => 'FAQ Akkordeon',
    'fields' => array(
        array(
            'key' => 'field_faq_titel',
            'label' => 'Titel',
            'name' => 'titel',
            'type' => 'text',
            'instructions' => 'Optionaler Titel für die FAQ-Liste',
            'required' => 0,
        ),
        array(
            'key' => 'field_faq_liste',
            'label' => 'FAQ-Liste',
            'name' => 'faq_liste',
            'type' => 'repeater',
            'instructions' => 'Fügen Sie Fragen und Antworten hinzu',
            'required' => 1,
            'min' => 1,
            'layout' => 'row',
            'sub_fields' => array(
                array(
                    'key' => 'field_faq_frage',
                    'label' => 'Frage',
                    'name' => 'frage',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_faq_antwort',
                    'label' => 'Antwort',
                    'name' => 'antwort',
                    'type' => 'textarea',
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
                'value' => 'acf/faq-akkordeon',
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
