<?php
// fields.php für mini-faq-am-rand Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_mini_faq_am_rand',
    'title' => 'Mini FAQ am Rand Felder',
    'fields' => array(
        array(
            'key' => 'field_faq_titel',
            'label' => 'FAQ Titel',
            'name' => 'faq_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_faq_liste',
            'label' => 'FAQ Liste',
            'name' => 'faq_liste',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_faq_frage',
                    'label' => 'Frage',
                    'name' => 'frage',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_faq_antwort',
                    'label' => 'Antwort',
                    'name' => 'antwort',
                    'type' => 'textarea',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/mini-faq-am-rand',
            ),
        ),
    ),
));
endif;
