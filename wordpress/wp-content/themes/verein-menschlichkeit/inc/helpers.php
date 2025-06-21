<?php
/**
 * Hilfsfunktionen für das Theme
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Breadcrumb Navigation
 */
function verein_menschlichkeit_breadcrumbs() {
    if (!is_front_page()) {
        echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumb Navigation', 'verein-menschlichkeit') . '">';
        echo '<ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">';
        
        // Startseite
        echo '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<a href="' . esc_url(home_url('/')) . '" itemprop="item"><span itemprop="name">' . esc_html__('Startseite', 'verein-menschlichkeit') . '</span></a>';
        echo '<meta itemprop="position" content="1" />';
        echo '</li>';
        
        $position = 2;
        
        if (is_category() || is_single()) {
            $categories = get_the_category();
            if (!empty($categories)) {
                $category = $categories[0];
                echo '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" itemprop="item"><span itemprop="name">' . esc_html($category->name) . '</span></a>';
                echo '<meta itemprop="position" content="' . $position . '" />';
                echo '</li>';
                $position++;
            }
            
            if (is_single()) {
                echo '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
                echo '<meta itemprop="position" content="' . $position . '" />';
                echo '</li>';
            }
        } elseif (is_page()) {
            // Übergeordnete Seiten
            $ancestors = get_post_ancestors(get_the_ID());
            $ancestors = array_reverse($ancestors);
            
            foreach ($ancestors as $ancestor) {
                echo '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="' . esc_url(get_permalink($ancestor)) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title($ancestor)) . '</span></a>';
                echo '<meta itemprop="position" content="' . $position . '" />';
                echo '</li>';
                $position++;
            }
            
            echo '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
        } elseif (is_archive()) {
            echo '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . esc_html(get_the_archive_title()) . '</span>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
        } elseif (is_search()) {
            echo '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . sprintf(esc_html__('Suchergebnisse für: %s', 'verein-menschlichkeit'), get_search_query()) . '</span>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
        } elseif (is_404()) {
            echo '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . esc_html__('Seite nicht gefunden', 'verein-menschlichkeit') . '</span>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
        }
        
        echo '</ol>';
        echo '</nav>';
    }
}

/**
 * Auto-Navigation für Seiten
 */
function verein_menschlichkeit_auto_nav($content) {
    if (!is_singular() || is_admin()) {
        return $content;
    }
    
    // Cache für bessere Performance
    $cache_key = 'verein_auto_nav_links';
    $links = wp_cache_get($cache_key);
    
    if ($links === false) {
        $links = [
            'team' => get_page_by_path('team'),
            'veranstaltungen' => get_page_by_path('veranstaltungen'),
            'downloads' => get_page_by_path('downloads'),
            'faq' => get_page_by_path('faq'),
            'galerie' => get_page_by_path('galerie'),
            'newsletter' => get_page_by_path('newsletter'),
            'presse' => get_page_by_path('presse'),
            'partner' => get_page_by_path('partner'),
            'sitemap' => get_page_by_path('sitemap'),
            'kontakt' => get_page_by_path('kontakt'),
        ];
        wp_cache_set($cache_key, $links, '', HOUR_IN_SECONDS);
    }
    
    $nav = '<nav class="verein-auto-nav" role="navigation" aria-label="' . esc_attr__('Schnellnavigation', 'verein-menschlichkeit') . '">';
    $nav .= '<div class="auto-nav-container">';
    
    $link_count = 0;
    foreach ($links as $slug => $page) {
        if ($page && get_permalink($page) && $link_count < 8) { // Maximal 8 Links
            $nav .= '<a href="' . esc_url(get_permalink($page)) . '" class="auto-nav-link btn-secondary">' . esc_html(get_the_title($page)) . '</a>';
            $link_count++;
        }
    }
    
    $nav .= '</div>';
    $nav .= '</nav>';
    
    return $nav . $content;
}
add_filter('the_content', 'verein_menschlichkeit_auto_nav', 5);

/**
 * Geschätzte Lesezeit berechnen
 */
function verein_menschlichkeit_reading_time($content = '') {
    if (empty($content)) {
        $content = get_post_field('post_content', get_the_ID());
    }
    
    $word_count = str_word_count(strip_tags($content));
    $minutes = floor($word_count / 200); // Durchschnittlich 200 Wörter pro Minute
    
    if ($minutes < 1) {
        return __('Weniger als 1 Minute Lesezeit', 'verein-menschlichkeit');
    } elseif ($minutes == 1) {
        return __('1 Minute Lesezeit', 'verein-menschlichkeit');
    } else {
        return sprintf(__('%d Minuten Lesezeit', 'verein-menschlichkeit'), $minutes);
    }
}

/**
 * Excerpt mit benutzerdefinierten Länge
 */
function verein_menschlichkeit_custom_excerpt($length = 20, $more = '...') {
    $excerpt = get_the_excerpt();
    if (empty($excerpt)) {
        $excerpt = get_the_content();
    }
    
    $excerpt = wp_strip_all_tags($excerpt);
    $words = explode(' ', $excerpt);
    
    if (count($words) > $length) {
        $excerpt = implode(' ', array_slice($words, 0, $length)) . $more;
    }
    
    return $excerpt;
}

/**
 * Sichere Ausgabe von ACF-Feldern
 */
function verein_menschlichkeit_get_field($field_name, $post_id = null, $format_value = true) {
    if (function_exists('get_field')) {
        return get_field($field_name, $post_id, $format_value);
    }
    
    // Fallback wenn ACF nicht aktiv
    if ($post_id) {
        return get_post_meta($post_id, $field_name, true);
    }
    
    return get_post_meta(get_the_ID(), $field_name, true);
}

/**
 * Theme Version für Cache Busting
 */
function verein_menschlichkeit_asset_version() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        return time();
    }
    
    return wp_get_theme()->get('Version');
}

/**
 * Sanitize CSS Classes
 */
function verein_menschlichkeit_sanitize_css_class($class) {
    return sanitize_html_class($class);
}

/**
 * Format Telefonnummer für href
 */
function verein_menschlichkeit_format_phone_href($phone) {
    return 'tel:' . preg_replace('/[^0-9+]/', '', $phone);
}

/**
 * Format Email für href
 */
function verein_menschlichkeit_format_email_href($email) {
    return 'mailto:' . sanitize_email($email);
}

/**
 * Prüfe ob Seite ist Child-Page
 */
function verein_menschlichkeit_is_child_page() {
    global $post;
    return ($post && $post->post_parent > 0);
}

/**
 * Get Child Pages
 */
function verein_menschlichkeit_get_child_pages($parent_id = null) {
    if (!$parent_id) {
        $parent_id = get_the_ID();
    }
    
    return get_children([
        'post_parent' => $parent_id,
        'post_type' => 'page',
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ]);
}
