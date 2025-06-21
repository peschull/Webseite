<?php
// fields.php für textzitat-grossinitial Block
// Beispielhafte ACF-Felddefinitionen
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_textzitat_grossinitial',
    'title' => 'Textzitat Großinitial Felder',
    'fields' => array(
        array(
            'key' => 'field_grossinitial',
            'label' => 'Großinitial',
            'name' => 'grossinitial',
            'type' => 'text',
        ),
        array(
            'key' => 'field_zitat_text',
            'label' => 'Zitat Text',
            'name' => 'zitat_text',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_zitat_autor',
            'label' => 'Zitat Autor',
            'name' => 'zitat_autor',
            'type' => 'text',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/textzitat-grossinitial',
            ),
        ),
    ),
));
endif;
