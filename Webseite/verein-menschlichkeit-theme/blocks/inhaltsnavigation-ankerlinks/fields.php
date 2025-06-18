<?php
/**
 * ACF Felder für den Inhaltsnavigation-Ankerlinks Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_inhaltsnavigation',
    'title' => 'Inhaltsnavigation Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_heading_selector',
            'label' => 'Überschriften-Selektor',
            'name' => 'heading_selector',
            'type' => 'select',
            'choices' => array(
                'h1' => 'Überschrift 1 (H1)',
                'h2' => 'Überschrift 2 (H2)',
                'h3' => 'Überschrift 3 (H3)',
                'h2, h3' => 'Überschrift 2 und 3 (H2, H3)',
            ),
            'default_value' => 'h2',
            'instructions' => 'Wählen Sie aus, welche Überschriften in der Navigation erscheinen sollen.',
        ),
        array(
            'key' => 'field_smooth_scroll',
            'label' => 'Sanftes Scrollen',
            'name' => 'smooth_scroll',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 1,
            'instructions' => 'Aktiviert sanftes Scrollen zu den Abschnitten.',
        ),
        array(
            'key' => 'field_sticky_navigation',
            'label' => 'Fixierte Navigation',
            'name' => 'sticky_navigation',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 1,
            'instructions' => 'Navigation beim Scrollen fixieren.',
        ),
        array(
            'key' => 'field_show_numbers',
            'label' => 'Nummerierung anzeigen',
            'name' => 'show_numbers',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 0,
            'instructions' => 'Zeigt eine fortlaufende Nummerierung vor den Navigationspunkten an.',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/inhaltsnavigation-ankerlinks',
            ),
        ),
    ),
));

endif;
