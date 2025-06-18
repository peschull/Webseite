<?php
/**
 * ACF Felder für den Petitions-Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_petition_block',
    'title' => 'Petitions-Block Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_petition_title',
            'label' => 'Petitions-Titel',
            'name' => 'petition_title',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_petition_content',
            'label' => 'Petitions-Inhalt',
            'name' => 'petition_content',
            'type' => 'wysiwyg',
            'required' => 1,
        ),
        array(
            'key' => 'field_current_signatures',
            'label' => 'Aktuelle Unterschriften',
            'name' => 'current_signatures',
            'type' => 'number',
            'default_value' => 0,
            'min' => 0,
        ),
        array(
            'key' => 'field_signature_goal',
            'label' => 'Unterschriften-Ziel',
            'name' => 'signature_goal',
            'type' => 'number',
            'required' => 1,
            'min' => 1,
            'default_value' => 1000,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/petitions-block',
            ),
        ),
    ),
));

endif;
