<?php
// ACF-Felddefinition für den Live-Suchfeld-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_live_suchfeld',
        'title' => 'Live-Suchfeld',
        'fields' => array(
            array(
                'key' => 'field_placeholder',
                'label' => 'Platzhalter',
                'name' => 'placeholder',
                'type' => 'text',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/live-suchfeld',
                ),
            ),
        ),
    ));
}
