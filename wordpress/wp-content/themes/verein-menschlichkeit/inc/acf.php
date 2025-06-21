<?php
/**
 * ACF (Advanced Custom Fields) Konfiguration
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ACF JSON Pfad definieren
 */
function verein_menschlichkeit_acf_json_save_point($path) {
    return get_template_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'verein_menschlichkeit_acf_json_save_point');

function verein_menschlichkeit_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'verein_menschlichkeit_acf_json_load_point');

/**
 * Sichere ACF Helper Funktion
 * Fallback wenn ACF nicht aktiv ist
 */
function vmh_get_field($field, $post_id = false, $format_value = true) {
    if (function_exists('get_field')) {
        return get_field($field, $post_id, $format_value);
    }
    
    // Fallback auf get_post_meta
    if ($post_id === false) {
        $post_id = get_the_ID();
    }
    
    if ($post_id) {
        return get_post_meta($post_id, $field, true);
    }
    
    return '';
}

/**
 * ACF Options Helper
 */
function vmh_get_option($field, $format_value = true) {
    if (function_exists('get_field')) {
        return get_field($field, 'option', $format_value);
    }
    
    return get_option($field, '');
}

/**
 * ACF Optionen Seite hinzufügen
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => __('Theme Optionen', 'verein-menschlichkeit'),
        'menu_title' => __('Theme Optionen', 'verein-menschlichkeit'),
        'menu_slug' => 'theme-options',
        'capability' => 'edit_theme_options',
        'icon_url' => 'dashicons-admin-generic',
        'position' => 30,
    ]);
    
    // Sub-Seiten hinzufügen
    acf_add_options_sub_page([
        'page_title' => __('Kontakt Einstellungen', 'verein-menschlichkeit'),
        'menu_title' => __('Kontakt', 'verein-menschlichkeit'),
        'parent_slug' => 'theme-options',
    ]);
    
    acf_add_options_sub_page([
        'page_title' => __('Social Media', 'verein-menschlichkeit'),
        'menu_title' => __('Social Media', 'verein-menschlichkeit'),
        'parent_slug' => 'theme-options',
    ]);
    
    acf_add_options_sub_page([
        'page_title' => __('Footer Einstellungen', 'verein-menschlichkeit'),
        'menu_title' => __('Footer', 'verein-menschlichkeit'),
        'parent_slug' => 'theme-options',
    ]);
}

/**
 * ACF Block Kategorien hinzufügen
 */
function verein_menschlichkeit_block_categories($categories, $post) {
    return array_merge(
        $categories,
        [
            [
                'slug' => 'menschlichkeit',
                'title' => __('Verein Menschlichkeit', 'verein-menschlichkeit'),
                'icon' => 'heart',
            ],
            [
                'slug' => 'menschlichkeit-content',
                'title' => __('Inhalts-Blöcke', 'verein-menschlichkeit'),
                'icon' => 'admin-post',
            ],
            [
                'slug' => 'menschlichkeit-layout',
                'title' => __('Layout-Blöcke', 'verein-menschlichkeit'),
                'icon' => 'editor-table',
            ],
        ]
    );
}
add_filter('block_categories_all', 'verein_menschlichkeit_block_categories', 10, 2);

/**
 * ACF Google Maps API Key
 */
function verein_menschlichkeit_acf_google_maps_api($api) {
    $api['key'] = get_option('acf_google_maps_api_key', '');
    return $api;
}
add_filter('acf/fields/google_map/api', 'verein_menschlichkeit_acf_google_maps_api');

/**
 * ACF Theme Optionen Validierung
 */
function verein_menschlichkeit_acf_validate_email($valid, $value, $field, $input) {
    if (!$valid || !$value) {
        return $valid;
    }
    
    if (!is_email($value)) {
        $valid = __('Bitte geben Sie eine gültige E-Mail-Adresse ein.', 'verein-menschlichkeit');
    }
    
    return $valid;
}
add_filter('acf/validate_value/type=email', 'verein_menschlichkeit_acf_validate_email', 10, 4);

/**
 * ACF URL Validierung
 */
function verein_menschlichkeit_acf_validate_url($valid, $value, $field, $input) {
    if (!$valid || !$value) {
        return $valid;
    }
    
    if (!filter_var($value, FILTER_VALIDATE_URL)) {
        $valid = __('Bitte geben Sie eine gültige URL ein.', 'verein-menschlichkeit');
    }
    
    return $valid;
}
add_filter('acf/validate_value/type=url', 'verein_menschlichkeit_acf_validate_url', 10, 4);

/**
 * ACF Admin Styles
 */
function verein_menschlichkeit_acf_admin_styles() {
    ?>
    <style>
        .acf-field-group {
            background: #fff;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 20px;
        }
        
        .acf-field-group .acf-field-group-title {
            color: #2563eb;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .acf-field-object {
            border-left: 3px solid #2563eb;
            padding-left: 15px;
        }
        
        .acf-field-object:hover {
            background-color: #f8fafc;
        }
        
        .acf-field-setting {
            background: #f9fafb;
            border-radius: 3px;
            padding: 10px;
        }
        
        .acf-icon-picker {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
            gap: 5px;
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .acf-icon-picker input[type="radio"] {
            display: none;
        }
        
        .acf-icon-picker label {
            display: block;
            padding: 8px;
            text-align: center;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.2s;
        }
        
        .acf-icon-picker label:hover {
            background-color: #e5e7eb;
        }
        
        .acf-icon-picker input[type="radio"]:checked + label {
            background-color: #2563eb;
            color: white;
        }
    </style>
    <?php
}
add_action('acf/input/admin_head', 'verein_menschlichkeit_acf_admin_styles');

/**
 * ACF Block Preview für Backend
 */
function verein_menschlichkeit_acf_block_preview($attributes, $content, $block) {
    if (isset($block['example'])) {
        return $block['example'];
    }
    
    return '<div style="padding: 20px; background: #f0f0f0; border: 2px dashed #ccc; text-align: center; color: #666;">' . 
           sprintf(__('Vorschau für %s Block', 'verein-menschlichkeit'), $block['title']) . 
           '</div>';
}

/**
 * ACF Repeater Performance Optimierung
 */
function verein_menschlichkeit_acf_repeater_performance() {
    // Limitiere Repeater Rows im Backend
    add_filter('acf/fields/repeater/max_rows', function($max, $field) {
        return min($max, 50); // Maximal 50 Rows
    }, 10, 2);
    
    // Lazy Loading für große Repeater
    add_filter('acf/fields/repeater/lazy_load', '__return_true');
}
add_action('acf/init', 'verein_menschlichkeit_acf_repeater_performance');
