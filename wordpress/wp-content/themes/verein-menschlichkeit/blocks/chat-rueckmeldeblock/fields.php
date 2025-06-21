<?php
/**
 * ACF Felder für Chat-Rückmeldeblock
 */

if (function_exists('acf_add_local_field_group')) :

acf_add_local_field_group(array(
    'key' => 'group_chat_rueckmeldeblock',
    'title' => 'Chat Rückmeldeblock',
    'fields' => array(
        array(
            'key' => 'field_chat_message',
            'label' => 'Chat-Nachricht',
            'name' => 'chat_message',
            'type' => 'textarea',
            'required' => 1,
        ),
        array(
            'key' => 'field_chat_user',
            'label' => 'Benutzername',
            'name' => 'chat_user',
            'type' => 'text',
            'required' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/chat-rueckmeldeblock',
            ),
        ),
    ),
));

endif;
