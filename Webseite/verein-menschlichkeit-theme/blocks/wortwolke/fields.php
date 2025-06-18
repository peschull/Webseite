<?php
// ACF-Felddefinition für den Wortwolke-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_wortwolke',
        'title' => 'Wortwolke',
        'fields' => array(
            array(
                'key' => 'field_wortwolke_text',
                'label' => 'Text',
                'name' => 'text',
                'type' => 'textarea',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/wortwolke',
                ),
            ),
        ),
    ));
}
