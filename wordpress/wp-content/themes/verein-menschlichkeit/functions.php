<?php
// Modularisierung: Setup und Enqueue auslagern
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/acf.php';

// --- Optimierungen und Aufräumarbeiten ---
// Scripte und Styles nur laden, wenn nötig
function verein_menschlichkeit_enqueue_scripts() {
  if (!is_admin()) {
    wp_enqueue_style('verein-style', get_stylesheet_uri(), [], null);
    if (function_exists('civicrm_in_wordpress') && civicrm_in_wordpress()) {
      wp_enqueue_style('verein-civicrm', get_template_directory_uri() . '/civicrm.css', [], null);
      wp_enqueue_script('verein-civicrm-js', get_template_directory_uri() . '/civicrm-theme.js', [], null, true);
    }
    wp_enqueue_style('verein-fonts', get_template_directory_uri() . '/fonts/fonts.css', [], null);
  }
}
add_action('wp_enqueue_scripts', 'verein_menschlichkeit_enqueue_scripts', 11);

// Unnötige WP-Header-Ausgaben entfernen
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

// HTML-Komprimierung (einfach)
function verein_menschlichkeit_html_minify($buffer) {
  return preg_replace(['/\>[\s]+</', '/\s{2,}/'], ['><', ' '], $buffer);
}
function verein_menschlichkeit_start_buffer() {
  ob_start('verein_menschlichkeit_html_minify');
}
add_action('template_redirect', 'verein_menschlichkeit_start_buffer');

// Social Media Links (Customizer)
function verein_menschlichkeit_customize_social($wp_customize) {
  $wp_customize->add_section('verein_social', [
    'title'    => __('Social Media', 'verein-menschlichkeit'),
    'priority' => 40,
  ]);
  $wp_customize->add_setting('verein_facebook', ['default' => '', 'sanitize_callback' => 'esc_url']);
  $wp_customize->add_control('verein_facebook', [
    'label'   => __('Facebook URL', 'verein-menschlichkeit'),
    'section' => 'verein_social',
    'type'    => 'url',
  ]);
  $wp_customize->add_setting('verein_instagram', ['default' => '', 'sanitize_callback' => 'esc_url']);
  $wp_customize->add_control('verein_instagram', [
    'label'   => __('Instagram URL', 'verein-menschlichkeit'),
    'section' => 'verein_social',
    'type'    => 'url',
  ]);
}
add_action('customize_register', 'verein_menschlichkeit_customize_social');

// Shortcode: Button
function verein_button_shortcode($atts, $content = null) {
  $atts = shortcode_atts([
    'url' => '#',
    'style' => 'primary',
    'target' => '_self',
  ], $atts, 'verein_button');
  $class = $atts['style'] === 'secondary' ? 'btn-secondary' : 'btn-primary';
  return '<a href="' . esc_url($atts['url']) . '" class="' . esc_attr($class) . '" target="' . esc_attr($atts['target']) . '">' . do_shortcode($content) . '</a>';
}
add_shortcode('verein_button', 'verein_button_shortcode');

// Shortcode: Infobox
function verein_infobox_shortcode($atts, $content = null) {
  $atts = shortcode_atts([
    'type' => 'info', // info, success, warning, error
  ], $atts, 'verein_infobox');
  $class = 'infobox infobox-' . esc_attr($atts['type']);
  return '<div class="' . $class . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('verein_infobox', 'verein_infobox_shortcode');

// Gutenberg-Block-Styles
add_theme_support('editor-styles');
add_editor_style('style.css');

// Lazy Load für Bilder (Performance)
add_filter('wp_lazy_loading_enabled', '__return_true');

// SVG-Upload entfernt, da unzureichend sanitisiert. Bei Bedarf sicheren Upload-Handler nutzen.

// Beitragsauszüge für Seiten aktivieren
add_post_type_support('page', 'excerpt');

// Favicon über Customizer
function verein_menschlichkeit_site_icon() {
  if (!has_site_icon()) {
    /**
 * Security Headers für besseren Schutz
 */
function verein_menschlichkeit_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        // Content Security Policy (nur für Produktionsumgebung)
        if (!WP_DEBUG) {
            header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' https:; connect-src 'self';");
        }
    }
}
add_action('init', 'verein_menschlichkeit_security_headers');

/**
 * Performance Optimierungen
 */
function verein_menschlichkeit_performance_optimizations() {
    // Emoji Scripts deaktivieren
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // WordPress Embeds deaktivieren
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    
    // RSS Feed Links entfernen (falls nicht benötigt)
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    
    // WordPress Version verstecken
    remove_action('wp_head', 'wp_generator');
    
    // Heartbeat API optimieren
    add_filter('heartbeat_settings', function($settings) {
        $settings['interval'] = 60; // 60 Sekunden statt 15
        return $settings;
    });
}
add_action('init', 'verein_menschlichkeit_performance_optimizations');

/**
 * Cookie-Hinweis DSGVO-konform
 */
function verein_menschlichkeit_cookie_notice() {
    if (!isset($_COOKIE['verein_cookie_accepted'])) {
        ?>
        <div id="cookie-notice" class="cookie-notice" role="dialog" aria-labelledby="cookie-notice-title" aria-describedby="cookie-notice-desc">
            <div class="cookie-notice-container">
                <div class="cookie-notice-content">
                    <h3 id="cookie-notice-title"><?php esc_html_e('Cookie-Hinweis', 'verein-menschlichkeit'); ?></h3>
                    <p id="cookie-notice-desc">
                        <?php esc_html_e('Diese Website verwendet Cookies, um Ihnen die bestmögliche Nutzererfahrung zu bieten. Durch die weitere Nutzung stimmen Sie der Verwendung zu.', 'verein-menschlichkeit'); ?>
                        <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" target="_blank" rel="noopener">
                            <?php esc_html_e('Mehr erfahren', 'verein-menschlichkeit'); ?>
                        </a>
                    </p>
                </div>
                <div class="cookie-notice-actions">
                    <button type="button" id="cookie-accept" class="btn btn-primary">
                        <?php esc_html_e('Akzeptieren', 'verein-menschlichkeit'); ?>
                    </button>
                    <button type="button" id="cookie-decline" class="btn btn-secondary">
                        <?php esc_html_e('Ablehnen', 'verein-menschlichkeit'); ?>
                    </button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cookieNotice = document.getElementById('cookie-notice');
                const acceptBtn = document.getElementById('cookie-accept');
                const declineBtn = document.getElementById('cookie-decline');
                
                if (acceptBtn) {
                    acceptBtn.addEventListener('click', function() {
                        document.cookie = 'verein_cookie_accepted=1; path=/; max-age=31536000; SameSite=Strict';
                        cookieNotice.style.display = 'none';
                    });
                }
                
                if (declineBtn) {
                    declineBtn.addEventListener('click', function() {
                        document.cookie = 'verein_cookie_accepted=0; path=/; max-age=31536000; SameSite=Strict';
                        cookieNotice.style.display = 'none';
                    });
                }
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'verein_menschlichkeit_cookie_notice');

/**
 * Barrierefreiheits-Tools
 */
function verein_menschlichkeit_accessibility_tools() {
    ?>
    <div id="accessibility-tools" class="accessibility-tools" aria-label="<?php esc_attr_e('Barrierefreiheits-Werkzeuge', 'verein-menschlichkeit'); ?>">
        <button type="button" id="accessibility-toggle" class="accessibility-toggle" aria-expanded="false" aria-controls="accessibility-panel">
            <span class="sr-only"><?php esc_html_e('Barrierefreiheits-Werkzeuge', 'verein-menschlichkeit'); ?></span>
            <span class="accessibility-icon" aria-hidden="true">♿</span>
        </button>
        <div id="accessibility-panel" class="accessibility-panel" hidden>
            <h3><?php esc_html_e('Barrierefreiheit', 'verein-menschlichkeit'); ?></h3>
            <div class="accessibility-controls">
                <button type="button" id="font-size-decrease" class="accessibility-btn">
                    <?php esc_html_e('Schrift verkleinern', 'verein-menschlichkeit'); ?>
                </button>
                <button type="button" id="font-size-increase" class="accessibility-btn">
                    <?php esc_html_e('Schrift vergrößern', 'verein-menschlichkeit'); ?>
                </button>
                <button type="button" id="font-size-reset" class="accessibility-btn">
                    <?php esc_html_e('Schrift zurücksetzen', 'verein-menschlichkeit'); ?>
                </button>
                <button type="button" id="high-contrast-toggle" class="accessibility-btn">
                    <?php esc_html_e('Hoher Kontrast', 'verein-menschlichkeit'); ?>
                </button>
                <button type="button" id="focus-mode-toggle" class="accessibility-btn">
                    <?php esc_html_e('Fokus-Modus', 'verein-menschlichkeit'); ?>
                </button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('accessibility-toggle');
            const panel = document.getElementById('accessibility-panel');
            const body = document.body;
            
            // Panel Toggle
            toggle.addEventListener('click', function() {
                const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', !isExpanded);
                panel.hidden = isExpanded;
            });
            
            // Schriftgrößen-Kontrollen
            let currentFontSize = 16;
            document.getElementById('font-size-increase').addEventListener('click', function() {
                currentFontSize = Math.min(currentFontSize + 2, 24);
                body.style.fontSize = currentFontSize + 'px';
                localStorage.setItem('accessibility_font_size', currentFontSize);
            });
            
            document.getElementById('font-size-decrease').addEventListener('click', function() {
                currentFontSize = Math.max(currentFontSize - 2, 12);
                body.style.fontSize = currentFontSize + 'px';
                localStorage.setItem('accessibility_font_size', currentFontSize);
            });
            
            document.getElementById('font-size-reset').addEventListener('click', function() {
                currentFontSize = 16;
                body.style.fontSize = '';
                localStorage.removeItem('accessibility_font_size');
            });
            
            // Hoher Kontrast
            document.getElementById('high-contrast-toggle').addEventListener('click', function() {
                body.classList.toggle('high-contrast');
                const isActive = body.classList.contains('high-contrast');
                localStorage.setItem('accessibility_high_contrast', isActive);
            });
            
            // Fokus-Modus
            document.getElementById('focus-mode-toggle').addEventListener('click', function() {
                body.classList.toggle('focus-mode');
                const isActive = body.classList.contains('focus-mode');
                localStorage.setItem('accessibility_focus_mode', isActive);
            });
            
            // Einstellungen beim Laden wiederherstellen
            const savedFontSize = localStorage.getItem('accessibility_font_size');
            if (savedFontSize) {
                currentFontSize = parseInt(savedFontSize);
                body.style.fontSize = currentFontSize + 'px';
            }
            
            if (localStorage.getItem('accessibility_high_contrast') === 'true') {
                body.classList.add('high-contrast');
            }
            
            if (localStorage.getItem('accessibility_focus_mode') === 'true') {
                body.classList.add('focus-mode');
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'verein_menschlichkeit_accessibility_tools', 300);

/**
 * WordPress Dashboard Anpassungen
 */
function verein_menschlichkeit_admin_customizations() {
    // Admin Footer Text anpassen
    add_filter('admin_footer_text', function() {
        return sprintf(
            __('Verein Menschlichkeit Theme by %s', 'verein-menschlichkeit'),
            '<a href="https://verein-menschlichkeit.de" target="_blank">Verein Menschlichkeit e.V.</a>'
        );
    });
    
    // Dashboard Widget hinzufügen
    add_action('wp_dashboard_setup', function() {
        wp_add_dashboard_widget(
            'verein_menschlichkeit_dashboard_widget',
            __('Verein Menschlichkeit', 'verein-menschlichkeit'),
            function() {
                ?>
                <div class="dashboard-widget-verein">
                    <h3><?php esc_html_e('Willkommen im Verein Menschlichkeit Theme', 'verein-menschlichkeit'); ?></h3>
                    <p><?php esc_html_e('Hier sind einige wichtige Links und Informationen:', 'verein-menschlichkeit'); ?></p>
                    <ul>
                        <li><a href="<?php echo esc_url(admin_url('themes.php?page=theme-options')); ?>"><?php esc_html_e('Theme Optionen', 'verein-menschlichkeit'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('customize.php')); ?>"><?php esc_html_e('Customizer', 'verein-menschlichkeit'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=team')); ?>"><?php esc_html_e('Team verwalten', 'verein-menschlichkeit'); ?></a></li>
                        <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=event')); ?>"><?php esc_html_e('Veranstaltungen verwalten', 'verein-menschlichkeit'); ?></a></li>
                    </ul>
                </div>
                <?php
            }
        );
    });
    
    // Admin Menü anpassen
    add_action('admin_menu', function() {
        // Theme Optionen Seite hinzufügen
        add_theme_page(
            __('Theme Optionen', 'verein-menschlichkeit'),
            __('Theme Optionen', 'verein-menschlichkeit'),
            'edit_theme_options',
            'theme-options',
            function() {
                ?>
                <div class="wrap">
                    <div class="theme-options-header">
                        <h1><?php esc_html_e('Theme Optionen', 'verein-menschlichkeit'); ?></h1>
                        <p><?php esc_html_e('Verwalten Sie hier die grundlegenden Einstellungen Ihres Themes.', 'verein-menschlichkeit'); ?></p>
                    </div>
                    
                    <div class="theme-options-section">
                        <h2><?php esc_html_e('Dokumentation', 'verein-menschlichkeit'); ?></h2>
                        <p><?php esc_html_e('Eine vollständige Dokumentation finden Sie in der README.md Datei im Theme-Ordner.', 'verein-menschlichkeit'); ?></p>
                    </div>
                    
                    <div class="theme-options-section">
                        <h2><?php esc_html_e('Support', 'verein-menschlichkeit'); ?></h2>
                        <p><?php esc_html_e('Bei Fragen oder Problemen wenden Sie sich an das Entwicklerteam.', 'verein-menschlichkeit'); ?></p>
                    </div>
                </div>
                <?php
            }
        );
    });
}
add_action('admin_init', 'verein_menschlichkeit_admin_customizations');

/**
 * Theme Update Checker (für Custom Themes)
 */
function verein_menschlichkeit_update_checker() {
    $theme_data = wp_get_theme();
    $current_version = $theme_data->get('Version');
    
    // Prüfe auf Updates (Beispiel-Implementation)
    $remote_version = wp_remote_get('https://api.verein-menschlichkeit.de/theme-version');
    
    if (!is_wp_error($remote_version)) {
        $remote_version = wp_remote_retrieve_body($remote_version);
        
        if (version_compare($current_version, $remote_version, '<')) {
            add_action('admin_notices', function() use ($remote_version) {
                ?>
                <div class="notice notice-info">
                    <p>
                        <?php printf(
                            esc_html__('Eine neue Version (%s) des Verein Menschlichkeit Themes ist verfügbar.', 'verein-menschlichkeit'),
                            esc_html($remote_version)
                        ); ?>
                    </p>
                </div>
                <?php
            });
        }
    }
}
// add_action('admin_init', 'verein_menschlichkeit_update_checker'); // Nur aktivieren wenn Update-Server vorhanden

/**
 * Debugging Hilfsfunktionen (nur für Development)
 */
if (defined('WP_DEBUG') && WP_DEBUG) {
    function verein_debug_log($message) {
        if (is_array($message) || is_object($message)) {
            error_log('[VEREIN THEME] ' . print_r($message, true));
        } else {
            error_log('[VEREIN THEME] ' . $message);
        }
    }
    
    // Debug-Informationen in Footer ausgeben
    add_action('wp_footer', function() {
        if (current_user_can('administrator')) {
            $queries = get_num_queries();
            $memory = size_format(memory_get_peak_usage());
            $load_time = timer_stop();
            
            echo "<!-- DEBUG: {$queries} Queries, {$memory} Memory, {$load_time}s Load Time -->";
        }
    });
}

// Shortcode: Testimonials-Slider
function verein_testimonials_shortcode($atts) {
  $atts = shortcode_atts(['anzahl' => 5], $atts, 'verein_testimonials');
  $query = new WP_Query([
    'post_type' => 'testimonial',
    'posts_per_page' => (int)$atts['anzahl'],
    'orderby' => 'rand'
  ]);
  if (!$query->have_posts()) return '';
  ob_start();
  ?>
  <div class="slider">
    <div class="slider-track">
      <?php while ($query->have_posts()) : $query->the_post(); ?>
        <div class="slider-slide">
          <blockquote><?php the_content(); ?></blockquote>
          <div class="font-bold mt-2"><?php the_title(); ?></div>
        </div>
      <?php endwhile; ?>
    </div>
    <div class="slider-nav">
      <?php for ($i=0; $i<$query->post_count; $i++) echo '<button type="button"></button>'; ?>
    </div>
  </div>
  <?php wp_reset_postdata();
  return ob_get_clean();
}
add_shortcode('verein_testimonials', 'verein_testimonials_shortcode');

// Sitemap-Shortcode
function verein_sitemap_shortcode() {
  ob_start();
  echo '<ul class="verein-sitemap">';
  wp_list_pages(['title_li' => '', 'exclude' => '']);
  echo '</ul><ul class="verein-sitemap">';
  $posts = get_posts(['numberposts' => 50]);
  foreach ($posts as $post) {
    echo '<li><a href="' . get_permalink($post) . '">' . esc_html(get_the_title($post)) . '</a></li>';
  }
  echo '</ul>';
  return ob_get_clean();
}
add_shortcode('verein_sitemap', 'verein_sitemap_shortcode');

// Schriftgrößenumschaltung (Barrierefreiheit)
add_action('wp_footer', function() {
  ?>
  <div id="font-size-switcher" style="position:fixed;bottom:1rem;left:1rem;z-index:9999;background:var(--neutral-0);border:1px solid var(--color-primary-600);padding:0.5rem 1rem;border-radius:0.7rem;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <button onclick="document.body.style.fontSize='1em'">A</button>
    <button onclick="document.body.style.fontSize='1.2em'">A+</button>
    <button onclick="document.body.style.fontSize='1.4em'">A++</button>
  </div>
  <?php
}, 300);

// Automatische Einbindung der wichtigsten Features auf passenden Seiten
add_filter('the_content', function($content) {
  if (is_page_template('team.php') && strpos($content, '[verein_testimonials]') === false) {
    $content .= do_shortcode('[verein_testimonials]');
  }
  if (is_page_template('downloads.php') && strpos($content, '[verein_sitemap]') === false) {
    $content .= do_shortcode('[verein_sitemap]');
  }
  if (is_page_template('faq.php') && strpos($content, '[verein_faq') === false) {
    $content .= do_shortcode('[verein_faq frage="Wie kann ich helfen?"]Melde dich über das Kontaktformular![/verein_faq]');
  }
  if (is_page_template('galerie.php') && strpos($content, 'gallery-filter') === false) {
    $filter = '<div class="gallery-filter">'
      .'<button data-filter="all" class="active">Alle</button>'
      .'<button data-filter="projekt">Projekte</button>'
      .'<button data-filter="event">Veranstaltungen</button>'
      .'</div>';
    $content = $filter . $content;
  }
  return $content;
});

// Automatische Navigation/Verlinkung zwischen den wichtigsten Seiten
function verein_menschlichkeit_auto_nav($content) {
  if (!is_singular()) return $content;
  $links = wp_cache_get('verein_auto_nav_links');
  if ($links === false) {
    $links = [
      'team' => get_page_by_path('team'),
      'veranstaltungen' => get_page_by_path('veranstaltungen'),
      'downloads' => get_page_by_path('downloads'),
      'faq' => get_page_by_path('faq'),
      'galerie' => get_page_by_path('galerie'),
      'newsletter' => get_page_by_path('newsletter'),
      'presse' => get_page_by_path('partner'),
      'sitemap' => get_page_by_path('sitemap'),
    ];
    wp_cache_set('verein_auto_nav_links', $links, '', HOUR_IN_SECONDS);
  }
  $nav = '<nav class="verein-auto-nav" style="margin:2rem 0 2.5rem 0;display:flex;flex-wrap:wrap;gap:1rem;">';
  foreach ($links as $slug => $page) {
    if ($page && get_permalink($page)) {
      $nav .= '<a href="' . esc_url(get_permalink($page)) . '" class="btn-secondary">' . esc_html(get_the_title($page)) . '</a>';
    }
  }
  $nav .= '</nav>';
  return $nav . $content;
}
add_filter('the_content', 'verein_menschlichkeit_auto_nav', 5);

// Benutzerdefinierte Skripte für Interaktionen
function verein_menschlichkeit_enqueue_custom_interaction() {
  wp_enqueue_script('verein-custom-interaction', get_template_directory_uri() . '/custom-interaction.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'verein_menschlichkeit_enqueue_custom_interaction', 50);

// Gutenberg: Eigene Blöcke für Vereinswebsite registrieren - Erweiterte Auswahl
add_action('init', function() {
    // Liste aller wichtigen Custom Blocks für eine Vereins-Website
    $priority_blocks = [
        // === KERN-BLÖCKE (Essentiell für jede Vereins-Website) ===
        'hero-section',                    // Hero-Bereich mit Call-to-Action
        'cta',                            // Call-to-Action-Block
        'button',                         // Button mit Icon
        'infobox',                        // Infobox/Hinweise
        
        // === MITGLIEDSCHAFT & ENGAGEMENT ===
        'mitglied-werden',                // Mitglied werden
        'mitglied-werden-3-karten-modul', // Mitgliedschaftsoptionen
        'so-kannst-du-helfen',            // Engagement-Möglichkeiten
        'mitmach-checkliste',             // Mitmach-Checkliste
        'mitmachschritte',                // Engagement-Schritte
        
        // === SPENDEN & UNTERSTÜTZUNG ===
        'spendenformular',                // Spendenformular
        'spendenleiste',                  // Spendenfortschritt
        'spendenfortschritt-animiert',    // Animierter Spendenfortschritt
        'spendenoptionen-direktvergleich', // Spendenoptionen vergleichen
        
        // === TEAM & PERSONEN ===
        'team',                           // Team-Übersicht
        'team-karte',                     // Team-Mitglieder Karten
        'vorstandsvorstellung',           // Vorstand vorstellen
        'ehrenamtliche-uebersicht',       // Ehrenamtliche
        
        // === PROJEKTE & WIRKUNG ===
        'projekt-grid',                   // Projekt-Übersicht
        'projekt-grid-mit-filter',        // Filterbare Projekte
        'projektfortschritt-karte',       // Projektfortschritt
        'erfolgsbeispiele',               // Erfolgsgeschichten
        'wichtige-zahlen',                // Wirkungszahlen
        'statistikblock-animiert',        // Animierte Statistiken
        
        // === VERANSTALTUNGEN & TERMINE ===
        'veranstaltungen',                // Veranstaltungsübersicht
        'veranstaltungskalender',         // Kalender
        'terminliste-mit-icons',          // Terminliste
        'event-box',                      // Event-Boxen
        
        // === CONTENT & INFORMATION ===
        'faq',                            // FAQ-Bereich
        'faq-akkordeon',                  // FAQ als Akkordeon
        'timeline',                       // Zeitleiste
        'testimonials',                   // Testimonials
        'galerie',                        // Bildergalerie
        'newsletter',                     // Newsletter-Anmeldung
        
        // === INTERAKTION & ENGAGEMENT ===
        'umfrageblock-sofortergebnis',    // Umfragen
        'abstimmungsmodul',               // Abstimmungen
        'quiz',                           // Quiz/Gamification
        'feedback-wertung-balken',        // Feedback-System
        
        // === KOMMUNIKATION ===
        'kontaktbereich-karte-telefon',   // Kontaktbereich
        'social-media-grid',              // Social Media
        'partnerlogos',                   // Partner/Sponsoren
        'laufleiste-partnerlogos',        // Partner-Laufband
        
        // === SPEZIAL-FUNKTIONEN ===
        'standortkarte',                  // Standorte/Karte
        'downloadbereich',                // Downloads
        'barrierefreiheits-modul',        // Barrierefreiheit
        'cookie-wahl',                    // Cookie-Einstellungen
        
        // === LEGACY BLÖCKE ===
        'slider',                         // Bild/Text-Slider
        'socialfeed',                     // Social Media Feed
        'pdfexport'                       // PDF-Export-Button
    ];
    
    foreach ($priority_blocks as $block) {
        $block_path = __DIR__ . '/blocks/' . $block;
        if (file_exists($block_path)) {
            register_block_type($block_path);
        }
    }
});

// Gutenberg: Block-Editor Assets einbinden (JS/CSS für Custom Blocks)
add_action('enqueue_block_editor_assets', function() {
    $priority_blocks = [
        'hero-section', 'cta', 'button', 'infobox',
        'mitglied-werden', 'mitglied-werden-3-karten-modul', 'so-kannst-du-helfen', 'mitmach-checkliste', 'mitmachschritte',
        'spendenformular', 'spendenleiste', 'spendenfortschritt-animiert', 'spendenoptionen-direktvergleich',
        'team', 'team-karte', 'vorstandsvorstellung', 'ehrenamtliche-uebersicht',
        'projekt-grid', 'projekt-grid-mit-filter', 'projektfortschritt-karte', 'erfolgsbeispiele', 'wichtige-zahlen', 'statistikblock-animiert',
        'veranstaltungen', 'veranstaltungskalender', 'terminliste-mit-icons', 'event-box',
        'faq', 'faq-akkordeon', 'timeline', 'testimonials', 'galerie', 'newsletter',
        'umfrageblock-sofortergebnis', 'abstimmungsmodul', 'quiz', 'feedback-wertung-balken',
        'kontaktbereich-karte-telefon', 'social-media-grid', 'partnerlogos', 'laufleiste-partnerlogos',
        'standortkarte', 'downloadbereich', 'barrierefreiheits-modul', 'cookie-wahl',
        'slider', 'socialfeed', 'pdfexport'
    ];
    
    foreach ($priority_blocks as $block) {
        $block_dir = get_template_directory_uri() . '/blocks/' . $block;
        $block_path = get_template_directory() . '/blocks/' . $block;
        
        if (file_exists($block_path)) {
            // JavaScript für Block-Editor
            if (file_exists($block_path . '/block.js')) {
                wp_enqueue_script('verein-block-' . $block, $block_dir . '/block.js', ['wp-blocks','wp-element','wp-editor'], null, true);
            }
            
            // Editor-CSS
            if (file_exists($block_path . '/editor.css')) {
                wp_enqueue_style('verein-block-' . $block . '-editor', $block_dir . '/editor.css', ['wp-edit-blocks'], null);
            }
            
            // Frontend-CSS
            if (file_exists($block_path . '/style.css')) {
                wp_enqueue_style('verein-block-' . $block . '-style', $block_dir . '/style.css', [], null);
            }
        }
    }
});

// Gutenberg: Custom Block-Kategorien für bessere Organisation
add_filter('block_categories_all', function($categories, $post) {
    return array_merge($categories, [
        [
            'slug'  => 'verein-kern',
            'title' => __('Verein: Kern-Blöcke', 'verein-menschlichkeit'),
            'icon'  => 'heart',
        ],
        [
            'slug'  => 'verein-mitgliedschaft',
            'title' => __('Verein: Mitgliedschaft', 'verein-menschlichkeit'),
            'icon'  => 'groups',
        ],
        [
            'slug'  => 'verein-spenden',
            'title' => __('Verein: Spenden', 'verein-menschlichkeit'),
            'icon'  => 'money-alt',
        ],
        [
            'slug'  => 'verein-projekte',
            'title' => __('Verein: Projekte', 'verein-menschlichkeit'),
            'icon'  => 'portfolio',
        ],
        [
            'slug'  => 'verein-team',
            'title' => __('Verein: Team', 'verein-menschlichkeit'),
            'icon'  => 'businessman',
        ],
        [
            'slug'  => 'verein-events',
            'title' => __('Verein: Veranstaltungen', 'verein-menschlichkeit'),
            'icon'  => 'calendar-alt',
        ],
        [
            'slug'  => 'verein-interaktion',
            'title' => __('Verein: Interaktion', 'verein-menschlichkeit'),
            'icon'  => 'feedback',
        ],
        [
            'slug'  => 'verein-kommunikation',
            'title' => __('Verein: Kommunikation', 'verein-menschlichkeit'),
            'icon'  => 'megaphone',
        ],
    ]);
}, 10, 2);

// Hinweis: Die eigentlichen Block-Implementierungen (block.json, block.js, editor.css, style.css) müssen im Ordner /blocks/<blockname>/ ergänzt werden.
// Beispiel für einen Block-Ordner: /blocks/cta/block.json, block.js, editor.css, style.css
// Siehe https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/ für Details.
