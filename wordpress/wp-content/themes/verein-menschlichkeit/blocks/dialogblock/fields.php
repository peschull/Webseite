<?php
// fields.php für dialogblock Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_dialogblock',
    'title' => 'Dialogblock Felder',
    'fields' => array(
        array(
            'key' => 'field_dialog_titel',
            'label' => 'Dialog Titel',
            'name' => 'dialog_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_dialog_inhalt',
            'label' => 'Dialog Inhalt',
            'name' => 'dialog_inhalt',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_dialog_person',
                    'label' => 'Person',
                    'name' => 'person',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_dialog_text',
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
                'value' => 'acf/dialogblock',
            ),
        ),
    ),
));
endif;
