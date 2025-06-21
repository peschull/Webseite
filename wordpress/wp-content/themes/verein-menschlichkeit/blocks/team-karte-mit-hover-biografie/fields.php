<?php
/**
 * ACF Felder für die Team Karte mit Hover Biografie
 */

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_team_card_hover',
        'title' => 'Team Karte mit Hover Biografie',
        'fields' => array(
            array(
                'key' => 'field_team_members',
                'label' => 'Team Mitglieder',
                'name' => 'team_members',
                'type' => 'repeater',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_team_member_image',
                        'label' => 'Foto',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_team_member_name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_team_member_position',
                        'label' => 'Position',
                        'name' => 'position',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_team_member_bio',
                        'label' => 'Biografie',
                        'name' => 'bio',
                        'type' => 'wysiwyg',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                    ),
                    array(
                        'key' => 'field_team_member_social',
                        'label' => 'Social Media Links',
                        'name' => 'social_links',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_social_platform',
                                'label' => 'Plattform',
                                'name' => 'platform',
                                'type' => 'select',
                                'choices' => array(
                                    'linkedin' => 'LinkedIn',
                                    'xing' => 'Xing',
                                    'twitter' => 'Twitter',
                                    'facebook' => 'Facebook',
                                    'instagram' => 'Instagram',
                                ),
                            ),
                            array(
                                'key' => 'field_social_url',
                                'label' => 'URL',
                                'name' => 'url',
                                'type' => 'url',
                                'required' => 1,
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/team-karte-mit-hover-biografie',
                ),
            ),
        ),
    ));
}
