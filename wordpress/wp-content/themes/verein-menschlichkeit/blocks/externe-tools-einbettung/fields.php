<?php
// fields.php für externe-tools-einbettung Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_externe_tools_einbettung',
    'title' => 'Externe Tools Einbettung Felder',
    'fields' => array(
        array(
            'key' => 'field_block_titel',
            'label' => 'Block Titel',
            'name' => 'block_titel',
            'type' => 'text',
        ),
        array(
            'key' => 'field_tool_embed_code',
            'label' => 'Tool Embed Code',
            'name' => 'tool_embed_code',
            'type' => 'textarea',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/externe-tools-einbettung',
            ),
        ),
    ),
));
endif;
