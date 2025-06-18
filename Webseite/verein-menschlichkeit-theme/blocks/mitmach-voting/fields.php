<?php
// ACF-Felddefinition für den Mitmach-Voting-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_mitmach_voting',
        'title' => 'Mitmach-Voting',
        'fields' => array(
            array(
                'key' => 'field_frage',
                'label' => 'Frage',
                'name' => 'frage',
                'type' => 'text',
            ),
            array(
                'key' => 'field_optionen',
                'label' => 'Optionen',
                'name' => 'optionen',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_option',
                        'label' => 'Option',
                        'name' => 'option',
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
                    'value' => 'acf/mitmach-voting',
                ),
            ),
        ),
    ));
}
