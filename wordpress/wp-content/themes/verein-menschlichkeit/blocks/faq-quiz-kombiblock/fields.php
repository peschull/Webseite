<?php
// fields.php für faq-quiz-kombiblock Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_faq_quiz_kombiblock',
    'title' => 'FAQ-Quiz Kombiblock Felder',
    'fields' => array(
        array(
            'key' => 'field_block_titel',
            'label' => 'Block Titel',
            'name' => 'block_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_faq_bereich',
            'label' => 'FAQ Bereich',
            'name' => 'faq_bereich',
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
        array(
            'key' => 'field_quiz_bereich',
            'label' => 'Quiz Bereich',
            'name' => 'quiz_bereich',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_quiz_frage',
                    'label' => 'Quizfrage',
                    'name' => 'quizfrage',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_quiz_antworten',
                    'label' => 'Antworten',
                    'name' => 'antworten',
                    'type' => 'textarea',
                ),
                array(
                    'key' => 'field_quiz_richtig',
                    'label' => 'Richtige Antwort',
                    'name' => 'richtig',
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
                'value' => 'acf/faq-quiz-kombiblock',
            ),
        ),
    ),
));
endif;
