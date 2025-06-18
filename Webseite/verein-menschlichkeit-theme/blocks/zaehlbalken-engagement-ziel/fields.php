<?php
// ACF-Felddefinition für den Zählbalken Engagement Ziel-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_zaehlbalken_engagement_ziel',
        'title' => 'Zählbalken Engagement Ziel',
        'fields' => array(
            array(
                'key' => 'field_wert',
                'label' => 'Wert',
                'name' => 'wert',
                'type' => 'number',
            ),
            array(
                'key' => 'field_ziel',
                'label' => 'Ziel',
                'name' => 'ziel',
                'type' => 'number',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/zaehlbalken-engagement-ziel',
                ),
            ),
        ),
    ));
}
