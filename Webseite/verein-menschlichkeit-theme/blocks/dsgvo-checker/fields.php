<?php
/**
 * ACF Felder für DSGVO-Checker
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_dsgvo_checker',
    'title' => 'DSGVO Checker',
    'fields' => array(
        array(
            'key' => 'field_dsgvo_checklist',
            'label' => 'Checkliste',
            'name' => 'checklist',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_check_item',
                    'label' => 'Prüfpunkt',
                    'name' => 'item',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_check_status',
                    'label' => 'Status',
                    'name' => 'status',
                    'type' => 'true_false',
                    'ui' => 1,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/dsgvo-checker',
            ),
        ),
    ),
));

endif;
