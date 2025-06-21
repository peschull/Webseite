<?php
// ACF-Felddefinition für den Vor-Ort-Galerie-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_vor_ort_galerie',
        'title' => 'Vor-Ort-Galerie',
        'fields' => array(
            array(
                'key' => 'field_bilder',
                'label' => 'Bilder',
                'name' => 'bilder',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_bild_url',
                        'label' => 'Bild URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                    array(
                        'key' => 'field_bild_alt',
                        'label' => 'Alt-Text',
                        'name' => 'alt',
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
                    'value' => 'acf/vor-ort-galerie',
                ),
            ),
        ),
    ));
}
