<?php
// fields.php für textsplitter-block Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_textsplitter_block',
    'title' => 'Textsplitter Block Felder',
    'fields' => array(
        array(
            'key' => 'field_splitter_titel',
            'label' => 'Splitter Titel',
            'name' => 'splitter_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_splitter_abschnitte',
            'label' => 'Splitter Abschnitte',
            'name' => 'splitter_abschnitte',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_abschnitt_text',
                    'label' => 'Text',
                    'name' => 'text',
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
                'value' => 'acf/textsplitter-block',
            ),
        ),
    ),
));
endif;
