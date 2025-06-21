<?php
/**
 * WordPress-Konfiguration für Verein Menschlichkeit
 * 
 * Diese Datei wird automatisch während der WordPress-Installation erstellt.
 * Weitere Informationen zur wp-config.php: https://de.wordpress.org/support/article/editing-wp-config-php/
 */

// ** MySQL-Einstellungen ** //
/** Der Name der Datenbank für WordPress */
define('DB_NAME', getenv('WP_DB_NAME') ?: 'verein_menschlichkeit');

/** MySQL-Datenbank-Benutzername */
define('DB_USER', getenv('WP_DB_USER') ?: 'wp_user');

/** MySQL-Datenbank-Passwort */
define('DB_PASSWORD', getenv('WP_DB_PASSWORD') ?: '');

/** MySQL-Hostname */
define('DB_HOST', getenv('WP_DB_HOST') ?: 'localhost');

/** Zeichensatz für die Datenbank */
define('DB_CHARSET', 'utf8mb4');

/** Der Collate-Type für die Datenbank */
define('DB_COLLATE', '');

/**#@+
 * Authentifizierungsschlüssel und Salts.
 * 
 * Ändere diese zu verschiedenen, eindeutigen Phrasen!
 * Du kannst dir diese über die {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service} generieren lassen
 */
define('AUTH_KEY',         getenv('WP_AUTH_KEY') ?: 'setze hier deinen eindeutigen Schlüssel ein');
define('SECURE_AUTH_KEY',  getenv('WP_SECURE_AUTH_KEY') ?: 'setze hier deinen eindeutigen Schlüssel ein');
define('LOGGED_IN_KEY',    getenv('WP_LOGGED_IN_KEY') ?: 'setze hier deinen eindeutigen Schlüssel ein');
define('NONCE_KEY',        getenv('WP_NONCE_KEY') ?: 'setze hier deinen eindeutigen Schlüssel ein');
define('AUTH_SALT',        getenv('WP_AUTH_SALT') ?: 'setze hier deinen eindeutigen Schlüssel ein');
define('SECURE_AUTH_SALT', getenv('WP_SECURE_AUTH_SALT') ?: 'setze hier deinen eindeutigen Schlüssel ein');
define('LOGGED_IN_SALT',   getenv('WP_LOGGED_IN_SALT') ?: 'setze hier deinen eindeutigen Schlüssel ein');
define('NONCE_SALT',       getenv('WP_NONCE_SALT') ?: 'setze hier deinen eindeutigen Schlüssel ein');

/**#@-*/

/**
 * WordPress-Datenbank-Tabellenpräfix.
 */
$table_prefix = 'wp_';

/**
 * Für Entwickler: WordPress-Debug-Modus.
 */
define('WP_DEBUG', getenv('WP_DEBUG') === 'true');
define('WP_DEBUG_LOG', getenv('WP_DEBUG_LOG') === 'true');
define('WP_DEBUG_DISPLAY', getenv('WP_DEBUG_DISPLAY') === 'true');

/**
 * CiviCRM-Konfiguration
 */
define('CIVICRM_SETTINGS_PATH', ABSPATH . 'wp-content/plugins/civicrm/civicrm.settings.php');
define('CIVICRM_PLUGIN_DIR', ABSPATH . 'wp-content/plugins/civicrm/');
define('CIVICRM_TEMPLATE_COMPILEDIR', ABSPATH . 'wp-content/uploads/civicrm/templates_c/');

/**
 * n8n Integration
 */
define('N8N_WEBHOOK_BASE_URL', getenv('N8N_WEBHOOK_BASE_URL') ?: 'http://localhost:5678/webhook');
define('N8N_API_KEY', getenv('N8N_API_KEY') ?: '');

/**
 * Sicherheit und Performance
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('WP_AUTO_UPDATE_CORE', false);
define('DISALLOW_FILE_EDIT', true);
define('WP_POST_REVISIONS', 3);
define('AUTOSAVE_INTERVAL', 300);
define('WP_MEMORY_LIMIT', '256M');

/**
 * SSL/HTTPS
 */
if (getenv('WORDPRESS_HTTPS') === 'true') {
    define('FORCE_SSL_ADMIN', true);
    $_SERVER['HTTPS'] = 'on';
}

/* Das ist alles, Schluss mit dem Bearbeiten! Viel Spaß beim Veröffentlichen. */

/** Absoluter Pfad zum WordPress-Verzeichnis. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** WordPress-Variablen und inkludierte Dateien laden. */
require_once(ABSPATH . 'wp-settings.php');
