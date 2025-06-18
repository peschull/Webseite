<?php
// fields.php für projektuebersicht-timeline-balken Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_projektuebersicht_timeline_balken',
    'title' => 'Projektübersicht Timeline Balken Felder',
    'fields' => array(
        array(
            'key' => 'field_timeline_titel',
            'label' => 'Timeline Titel',
            'name' => 'timeline_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_timeline_balken',
            'label' => 'Timeline Balken',
            'name' => 'timeline_balken',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_balken_label',
                    'label' => 'Balken Label',
                    'name' => 'balken_label',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_balken_start',
                    'label' => 'Start',
                    'name' => 'balken_start',
                    'type' => 'date_picker',
                ),
                array(
                    'key' => 'field_balken_ende',
                    'label' => 'Ende',
                    'name' => 'balken_ende',
                    'type' => 'date_picker',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/projektuebersicht-timeline-balken',
            ),
        ),
    ),
));
endif;
