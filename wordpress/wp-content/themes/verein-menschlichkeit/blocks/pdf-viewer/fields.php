<?php
/**
 * ACF Felder für den PDF-Viewer Block
 */

if (function_exists('acf_add_local_field_group')):

acf_add_local_field_group(array(
    'key' => 'group_pdf_viewer',
    'title' => 'PDF-Viewer Einstellungen',
    'fields' => array(
        array(
            'key' => 'field_pdf_file',
            'label' => 'PDF-Datei',
            'name' => 'pdf_file',
            'type' => 'file',
            'required' => 1,
            'return_format' => 'array',
            'mime_types' => 'pdf',
            'instructions' => 'Wählen Sie eine PDF-Datei aus der Mediathek aus.',
        ),
        array(
            'key' => 'field_viewer_height',
            'label' => 'Viewer-Höhe',
            'name' => 'viewer_height',
            'type' => 'number',
            'default_value' => 600,
            'min' => 300,
            'max' => 1200,
            'instructions' => 'Höhe des PDF-Viewers in Pixeln.',
        ),
        array(
            'key' => 'field_show_toolbar',
            'label' => 'PDF-Toolbar anzeigen',
            'name' => 'show_toolbar',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 1,
            'instructions' => 'Zeigt die PDF-Werkzeugleiste im Viewer an.',
        ),
        array(
            'key' => 'field_show_download',
            'label' => 'Download-Button anzeigen',
            'name' => 'show_download',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 1,
            'instructions' => 'Fügt einen Button zum Herunterladen der PDF-Datei hinzu.',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/pdf-viewer',
            ),
        ),
    ),
));

endif;
