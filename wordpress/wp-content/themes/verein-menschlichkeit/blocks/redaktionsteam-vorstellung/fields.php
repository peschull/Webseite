<?php
// fields.php für redaktionsteam-vorstellung Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_redaktionsteam_vorstellung',
    'title' => 'Redaktionsteam Vorstellung Felder',
    'fields' => array(
        array(
            'key' => 'field_block_titel',
            'label' => 'Block Titel',
            'name' => 'block_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_team_mitglieder',
            'label' => 'Teammitglieder',
            'name' => 'team_mitglieder',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'field_mitglied_name',
                    'label' => 'Name',
                    'name' => 'name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_mitglied_rolle',
                    'label' => 'Rolle',
                    'name' => 'rolle',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_mitglied_bild',
                    'label' => 'Bild',
                    'name' => 'bild',
                    'type' => 'image',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/redaktionsteam-vorstellung',
            ),
        ),
    ),
));
endif;
