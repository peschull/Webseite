<?php
/**
 * ACF Felder für den Projektmatrix Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_projektmatrix',
    'title' => 'Projektmatrix Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_show_filters',
            'label' => 'Filter anzeigen',
            'name' => 'show_filters',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 1,
        ),
        array(
            'key' => 'field_categories',
            'label' => 'Kategorien',
            'name' => 'categories',
            'type' => 'repeater',
            'layout' => 'table',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_show_filters',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'sub_fields' => array(
                array(
                    'key' => 'field_category_label',
                    'label' => 'Bezeichnung',
                    'name' => 'label',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_category_value',
                    'label' => 'Wert',
                    'name' => 'value',
                    'type' => 'text',
                    'required' => 1,
                ),
            ),
        ),
        array(
            'key' => 'field_projects',
            'label' => 'Projekte',
            'name' => 'projects',
            'type' => 'repeater',
            'layout' => 'block',
            'sub_fields' => array(
                array(
                    'key' => 'field_project_title',
                    'label' => 'Titel',
                    'name' => 'title',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_project_description',
                    'label' => 'Beschreibung',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_project_image',
                    'label' => 'Bild',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'array',
                ),
                array(
                    'key' => 'field_project_categories',
                    'label' => 'Kategorien',
                    'name' => 'categories',
                    'type' => 'select',
                    'multiple' => 1,
                    'ui' => 1,
                    'choices' => array(), // Wird dynamisch befüllt
                ),
                array(
                    'key' => 'field_project_status',
                    'label' => 'Status',
                    'name' => 'status',
                    'type' => 'select',
                    'choices' => array(
                        'active' => 'Aktiv',
                        'planned' => 'Geplant',
                        'completed' => 'Abgeschlossen',
                    ),
                    'default_value' => 'active',
                ),
                array(
                    'key' => 'field_project_link',
                    'label' => 'Link',
                    'name' => 'link',
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
                'value' => 'acf/projektmatrix',
            ),
        ),
    ),
));

endif;
