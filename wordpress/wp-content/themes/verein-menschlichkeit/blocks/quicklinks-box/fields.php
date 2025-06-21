<?php
// fields.php für quicklinks-box Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_quicklinks_box',
    'title' => 'Quicklinks Box Felder',
    'fields' => array(
        array(
            'key' => 'field_box_titel',
            'label' => 'Box Titel',
            'name' => 'box_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_quicklinks',
            'label' => 'Quicklinks',
            'name' => 'quicklinks',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_quicklink_text',
                    'label' => 'Link Text',
                    'name' => 'text',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_quicklink_url',
                    'label' => 'Link URL',
                    'name' => 'url',
                    'type' => 'url',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/quicklinks-box',
            ),
        ),
    ),
));
endif;
