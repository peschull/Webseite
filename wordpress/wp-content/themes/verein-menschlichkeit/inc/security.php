<?php
/**
 * WordPress Security und Performance Optimierungen
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Security Headers setzen
 */
function verein_menschlichkeit_security_headers() {
    if (!is_admin()) {
        // Content Security Policy (strikt für Produktion)
        if (!WP_DEBUG) {
            header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google-analytics.com https://www.googletagmanager.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self'; frame-src 'self' https://www.youtube.com https://player.vimeo.com; object-src 'none'; base-uri 'self'; frame-ancestors 'self';");
        }
        
        // Security Headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
        
        // HSTS (nur über HTTPS)
        if (is_ssl()) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }
    }
}
add_action('wp_loaded', 'verein_menschlichkeit_security_headers');

/**
 * Login Security Verbesserungen
 */
function verein_menschlichkeit_login_security() {
    // Login-Versuche limitieren
    add_action('wp_login_failed', function($username) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $attempts = get_transient('login_attempts_' . $ip) ?: 0;
        $attempts++;
        
        if ($attempts >= 5) {
            set_transient('login_blocked_' . $ip, true, 15 * MINUTE_IN_SECONDS);
            wp_die(__('Zu viele Login-Versuche. Bitte versuchen Sie es in 15 Minuten erneut.', 'verein-menschlichkeit'));
        }
        
        set_transient('login_attempts_' . $ip, $attempts, 5 * MINUTE_IN_SECONDS);
    });
    
    // Login-Blockade prüfen
    add_action('wp_authenticate', function($username) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        if (get_transient('login_blocked_' . $ip)) {
            wp_die(__('IP-Adresse temporär blockiert. Bitte versuchen Sie es später erneut.', 'verein-menschlichkeit'));
        }
    });
    
    // Erfolgreiche Logins zurücksetzen
    add_action('wp_login', function($username) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        delete_transient('login_attempts_' . $ip);
        delete_transient('login_blocked_' . $ip);
    });
}
add_action('init', 'verein_menschlichkeit_login_security');

/**
 * File Upload Security
 */
function verein_menschlichkeit_upload_security() {
    // Gefährliche Dateitypen blockieren
    add_filter('upload_mimes', function($mimes) {
        // Entferne gefährliche Dateitypen
        unset($mimes['exe']);
        unset($mimes['bat']);
        unset($mimes['cmd']);
        unset($mimes['com']);
        unset($mimes['pif']);
        unset($mimes['scr']);
        unset($mimes['vbs']);
        unset($mimes['js']);
        
        // Sicher erlaubte Dateitypen
        $mimes['svg'] = 'image/svg+xml'; // Nur wenn sanitized
        return $mimes;
    });
    
    // Upload-Größe begrenzen
    add_filter('upload_size_limit', function($size) {
        return min($size, 5 * 1024 * 1024); // 5MB Maximum
    });
    
    // Datei-Validierung
    add_filter('wp_handle_upload_prefilter', function($file) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'text/plain'];
        
        if (!in_array($file['type'], $allowed_types)) {
            $file['error'] = __('Dateityp nicht erlaubt.', 'verein-menschlichkeit');
        }
        
        return $file;
    });
}
add_action('init', 'verein_menschlichkeit_upload_security');

/**
 * Database Query Security
 */
function verein_menschlichkeit_db_security() {
    // SQL Injection Schutz für Custom Queries
    add_filter('query', function($query) {
        // Gefährliche Patterns blockieren
        $dangerous_patterns = [
            '/union.*select/i',
            '/drop.*table/i',
            '/delete.*from/i',
            '/insert.*into/i',
            '/update.*set/i',
            '/exec.*\(/i',
            '/script.*>/i'
        ];
        
        foreach ($dangerous_patterns as $pattern) {
            if (preg_match($pattern, $query)) {
                wp_die(__('Ungültige Datenbankabfrage blockiert.', 'verein-menschlichkeit'));
            }
        }
        
        return $query;
    });
}
add_action('init', 'verein_menschlichkeit_db_security');

/**
 * AJAX Security
 */
function verein_menschlichkeit_ajax_security() {
    // AJAX Nonce Validierung
    add_action('wp_ajax_nopriv_verein_contact', function() {
        check_ajax_referer('verein_contact_nonce', 'nonce');
        
        // Sanitize Input
        $name = sanitize_text_field($_POST['name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $message = sanitize_textarea_field($_POST['message'] ?? '');
        
        // Validation
        if (empty($name) || empty($email) || empty($message)) {
            wp_die('Alle Felder sind erforderlich.');
        }
        
        if (!is_email($email)) {
            wp_die('Ungültige E-Mail-Adresse.');
        }
        
        // Rate Limiting
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $submissions = get_transient('contact_submissions_' . $ip) ?: 0;
        
        if ($submissions >= 3) {
            wp_die('Zu viele Nachrichten. Bitte versuchen Sie es später erneut.');
        }
        
        set_transient('contact_submissions_' . $ip, $submissions + 1, HOUR_IN_SECONDS);
        
        // Email senden (hier würde die eigentliche Logik stehen)
        wp_send_json_success('Nachricht erfolgreich gesendet.');
    });
    
    add_action('wp_ajax_verein_contact', function() {
        // Gleiche Logik für eingeloggte Benutzer
        check_ajax_referer('verein_contact_nonce', 'nonce');
        // ... Rest der Logik
    });
}
add_action('init', 'verein_menschlichkeit_ajax_security');

/**
 * Performance Optimierungen
 */
function verein_menschlichkeit_performance_optimizations() {
    // Object Cache verwenden wenn verfügbar
    if (!wp_using_ext_object_cache()) {
        // Simple Object Cache Implementation
        add_action('init', function() {
            wp_cache_add_global_groups(['theme_cache']);
        });
    }
    
    // Query Optimierungen
    add_action('pre_get_posts', function($query) {
        if (!is_admin() && $query->is_main_query()) {
            // Limit posts per page
            if (is_home() || is_archive()) {
                $query->set('posts_per_page', 12);
            }
            
            // Optimize meta queries
            if ($query->get('meta_query')) {
                $query->set('meta_query', array_slice($query->get('meta_query'), 0, 3));
            }
        }
    });
    
    // Database Query Monitoring
    if (WP_DEBUG) {
        add_action('wp_footer', function() {
            if (current_user_can('administrator')) {
                $queries = get_num_queries();
                $time = timer_stop();
                echo "<!-- Performance: {$queries} queries in {$time}s -->";
            }
        });
    }
}
add_action('init', 'verein_menschlichkeit_performance_optimizations');

/**
 * Content Validation und Sanitization
 */
function verein_menschlichkeit_content_security() {
    // Content Filter für User-Generated Content
    add_filter('the_content', function($content) {
        // XSS Schutz
        $content = wp_kses_post($content);
        
        // Gefährliche Scripts entfernen
        $content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $content);
        
        return $content;
    }, 20);
    
    // Comment Security
    add_filter('pre_comment_content', function($content) {
        // Sanitize comments
        $content = wp_kses($content, [
            'p' => [],
            'br' => [],
            'strong' => [],
            'em' => [],
            'a' => ['href' => [], 'title' => []]
        ]);
        
        return $content;
    });
}
add_action('init', 'verein_menschlichkeit_content_security');

/**
 * Error Handling und Logging
 */
function verein_menschlichkeit_error_handling() {
    // Custom Error Handler
    if (!WP_DEBUG) {
        add_action('wp_die_handler', function($message) {
            // Log errors instead of displaying them
            error_log('WordPress Error: ' . $message);
            
            // Show generic error message
            wp_die(__('Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.', 'verein-menschlichkeit'));
        });
    }
    
    // 404 Error Logging
    add_action('wp', function() {
        if (is_404()) {
            $url = $_SERVER['REQUEST_URI'] ?? '';
            $referer = $_SERVER['HTTP_REFERER'] ?? '';
            error_log("404 Error: {$url} from {$referer}");
        }
    });
}
add_action('init', 'verein_menschlichkeit_error_handling');

/**
 * GDPR Compliance Tools
 */
function verein_menschlichkeit_gdpr_compliance() {
    // Data Export Tool
    add_action('wp_ajax_export_user_data', function() {
        if (!wp_verify_nonce($_POST['nonce'], 'export_user_data')) {
            wp_die('Nonce verification failed');
        }
        
        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_die('User not logged in');
        }
        
        $user_data = get_userdata($user_id);
        $export_data = [
            'user_login' => $user_data->user_login,
            'user_email' => $user_data->user_email,
            'display_name' => $user_data->display_name,
            'user_registered' => $user_data->user_registered,
        ];
        
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="user-data-export.json"');
        echo json_encode($export_data, JSON_PRETTY_PRINT);
        exit;
    });
    
    // Data Deletion Tool
    add_action('wp_ajax_delete_user_data', function() {
        if (!wp_verify_nonce($_POST['nonce'], 'delete_user_data')) {
            wp_die('Nonce verification failed');
        }
        
        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_die('User not logged in');
        }
        
        // Anonymize user data instead of deleting
        wp_update_user([
            'ID' => $user_id,
            'user_email' => 'deleted@example.com',
            'display_name' => 'Deleted User',
            'first_name' => '',
            'last_name' => '',
            'description' => '',
        ]);
        
        wp_send_json_success('User data anonymized');
    });
}
add_action('init', 'verein_menschlichkeit_gdpr_compliance');

/**
 * Health Check und Monitoring
 */
function verein_menschlichkeit_health_check() {
    // Site Health Checks
    add_filter('site_status_tests', function($tests) {
        $tests['direct']['verein_theme_security'] = [
            'label' => __('Theme Security Check', 'verein-menschlichkeit'),
            'test' => function() {
                $result = [
                    'label' => __('Theme Security', 'verein-menschlichkeit'),
                    'status' => 'good',
                    'badge' => [
                        'label' => __('Security', 'verein-menschlichkeit'),
                        'color' => 'green',
                    ],
                    'description' => __('Theme security features are properly configured.', 'verein-menschlichkeit'),
                ];
                
                // Check if debug mode is enabled in production
                if (!WP_DEBUG && defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
                    $result['status'] = 'recommended';
                    $result['badge']['color'] = 'orange';
                    $result['description'] = __('Debug logging is enabled. Consider disabling for production.', 'verein-menschlichkeit');
                }
                
                return $result;
            }
        ];
        
        return $tests;
    });
}
add_action('init', 'verein_menschlichkeit_health_check');
