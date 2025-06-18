<?php
/**
 * ACF Felder für das Projekt Grid mit Filter
 */

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_projekt_grid',
        'title' => 'Projekt Grid mit Filter',
        'fields' => array(
            array(
                'key' => 'field_heading',
                'label' => 'Überschrift',
                'name' => 'heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_subheading',
                'label' => 'Unterüberschrift',
                'name' => 'subheading',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            array(
                'key' => 'field_projects',
                'label' => 'Projekte',
                'name' => 'projects',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Projekt hinzufügen',
                'sub_fields' => array(
                    array(
                        'key' => 'field_project_image',
                        'label' => 'Projektbild',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_project_title',
                        'label' => 'Titel',
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_project_excerpt',
                        'label' => 'Kurzbeschreibung',
                        'name' => 'excerpt',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                    array(
                        'key' => 'field_project_category',
                        'label' => 'Kategorie',
                        'name' => 'category',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_project_status',
                        'label' => 'Status',
                        'name' => 'status',
                        'type' => 'select',
                        'choices' => array(
                            'Aktiv' => 'Aktiv',
                            'Geplant' => 'Geplant',
                            'Abgeschlossen' => 'Abgeschlossen',
                        ),
                    ),
                    array(
                        'key' => 'field_project_link',
                        'label' => 'Projektlink',
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
                    'value' => 'acf/projekt-grid-mit-filter',
                ),
            ),
        ),
    ));
}
