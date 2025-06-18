<?php
// Modularisierung: Setup und Enqueue auslagern
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
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

// SVG-Upload erlauben
function verein_menschlichkeit_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'verein_menschlichkeit_mime_types');

// Beitragsauszüge für Seiten aktivieren
add_post_type_support('page', 'excerpt');

// Favicon über Customizer
function verein_menschlichkeit_site_icon() {
  if (!has_site_icon()) {
    echo '<link rel="icon" href="' . esc_url(get_template_directory_uri() . '/favicon.ico') . '" type="image/x-icon">';
  }
}
add_action('wp_head', 'verein_menschlichkeit_site_icon');

// Cookie-Hinweis (einfach)
function verein_menschlichkeit_cookie_notice() {
  if (!isset($_COOKIE['verein_cookie_ok'])) {
    echo '<div id="cookie-notice" style="position:fixed;bottom:0;left:0;right:0;background:#2563eb;color:#fff;padding:1rem;text-align:center;z-index:9999;">'
      . esc_html__('Diese Website verwendet Cookies. Mit der Nutzung stimmen Sie zu.', 'verein-menschlichkeit')
      . ' <button onclick="document.cookie=\'verein_cookie_ok=1;path=/\';document.getElementById(\'cookie-notice\').remove();" style="margin-left:1rem;padding:0.3rem 1rem;border:none;border-radius:0.3rem;background:#fff;color:#2563eb;cursor:pointer;">OK</button></div>';
  }
}
add_action('wp_footer', 'verein_menschlichkeit_cookie_notice');

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
  <div id="font-size-switcher" style="position:fixed;bottom:1rem;left:1rem;z-index:9999;background:#fff;border:1px solid #2563eb;padding:0.5rem 1rem;border-radius:0.7rem;box-shadow:0 2px 8px #0001;">
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

// Gutenberg: Eigene Blöcke für Vereinswebsite registrieren
add_action('init', function() {
    // Liste aller gewünschten Custom Blocks
    $blocks = [
        'cta',              // Call-to-Action
        'spendenleiste',    // Spendenfortschritt
        'team',             // Team-Grid
        'veranstaltungen',  // Veranstaltungen-Übersicht
        'faq',              // FAQ-Akkordeon
        'galerie',          // Galerie/Lightbox
        'testimonials',     // Testimonials/Slider
        'button',           // Button mit Icon
        'infobox',          // Infobox/Hinweis
        'newsletter',       // Newsletter-Formular
        'slider',           // Bild/Text-Slider
        'quiz',             // Quiz/Gamification
        'socialfeed',       // Social Media Feed
        'pdfexport'         // PDF-Export-Button
    ];
    foreach ($blocks as $block) {
        register_block_type( __DIR__ . '/blocks/' . $block );
    }
});

// Gutenberg: Block-Editor Assets einbinden (JS/CSS für Custom Blocks)
add_action('enqueue_block_editor_assets', function() {
    $blocks = [
        'cta','spendenleiste','team','veranstaltungen','faq','galerie','testimonials','button','infobox','newsletter','slider','quiz','socialfeed','pdfexport'
    ];
    foreach ($blocks as $block) {
        $block_dir = get_template_directory_uri() . '/blocks/' . $block;
        wp_enqueue_script('verein-block-' . $block, $block_dir . '/block.js', ['wp-blocks','wp-element','wp-editor'], null, true);
        if (file_exists(get_template_directory() . '/blocks/' . $block . '/editor.css')) {
            wp_enqueue_style('verein-block-' . $block . '-editor', $block_dir . '/editor.css', ['wp-edit-blocks'], null);
        }
    }
});

// Hinweis: Die eigentlichen Block-Implementierungen (block.json, block.js, editor.css, style.css) müssen im Ordner /blocks/<blockname>/ ergänzt werden.
// Beispiel für einen Block-Ordner: /blocks/cta/block.json, block.js, editor.css, style.css
// Siehe https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/ für Details.
