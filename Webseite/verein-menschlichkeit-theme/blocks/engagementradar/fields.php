<?php
/**
 * ACF Felder für Engagementradar
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_engagementradar',
    'title' => 'Engagementradar',
    'fields' => array(
        array(
            'key' => 'field_engagement_items',
            'label' => 'Engagement-Punkte',
            'name' => 'engagement_items',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_engagement_label',
                    'label' => 'Label',
                    'name' => 'label',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_engagement_value',
                    'label' => 'Wert',
                    'name' => 'value',
                    'type' => 'number',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/engagementradar',
            ),
        ),
    ),
));

endif;
