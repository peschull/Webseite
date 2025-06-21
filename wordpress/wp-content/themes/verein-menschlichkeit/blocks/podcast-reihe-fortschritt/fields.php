<?php
// fields.php für podcast-reihe-fortschritt Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_podcast_reihe_fortschritt',
    'title' => 'Podcast-Reihe Fortschritt Felder',
    'fields' => array(
        array(
            'key' => 'field_podcast_titel',
            'label' => 'Podcast Titel',
            'name' => 'podcast_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_podcast_folgen',
            'label' => 'Podcast Folgen',
            'name' => 'podcast_folgen',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_folge_titel',
                    'label' => 'Folge Titel',
                    'name' => 'folge_titel',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_folge_audio',
                    'label' => 'Audio',
                    'name' => 'audio',
                    'type' => 'file',
                ),
                array(
                    'key' => 'field_folge_fortschritt',
                    'label' => 'Fortschritt',
                    'name' => 'fortschritt',
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
                'value' => 'acf/podcast-reihe-fortschritt',
            ),
        ),
    ),
));
endif;
