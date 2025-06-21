<?php
// ACF-Felddefinition für den Social Media Grid-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_social_media_grid',
        'title' => 'Social Media Grid',
        'fields' => array(
            array(
                'key' => 'field_links',
                'label' => 'Links',
                'name' => 'links',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_plattform',
                        'label' => 'Plattform',
                        'name' => 'plattform',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/social-media-grid',
                ),
            ),
        ),
    ));
}
