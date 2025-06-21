<?php
// ACF-Felddefinition für den Video-Galerie-Block
if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_video_galerie',
        'title' => 'Video-Galerie',
        'fields' => array(
            array(
                'key' => 'field_videos',
                'label' => 'Videos',
                'name' => 'videos',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_video_url',
                        'label' => 'Video URL',
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
                    'value' => 'acf/video-galerie',
                ),
            ),
        ),
    ));
}
