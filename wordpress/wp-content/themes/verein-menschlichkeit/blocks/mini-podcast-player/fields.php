<?php
/**
 * ACF Felder für den Mini-Podcast-Player Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_mini_podcast_player',
    'title' => 'Mini-Podcast-Player Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_episode_title',
            'label' => 'Episoden-Titel',
            'name' => 'episode_title',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_audio_url',
            'label' => 'Audio-URL',
            'name' => 'audio_url',
            'type' => 'url',
            'required' => 1,
            'instructions' => 'Die URL zur MP3-Datei der Episode',
        ),
        array(
            'key' => 'field_episode_duration',
            'label' => 'Episodenlänge',
            'name' => 'episode_duration',
            'type' => 'text',
            'instructions' => 'Format: MM:SS (z.B. 05:30)',
            'required' => 1,
        ),
        array(
            'key' => 'field_episode_description',
            'label' => 'Beschreibung',
            'name' => 'episode_description',
            'type' => 'textarea',
            'instructions' => 'Eine kurze Beschreibung der Episode',
            'rows' => 3,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/mini-podcast-player',
            ),
        ),
    ),
));

endif;
