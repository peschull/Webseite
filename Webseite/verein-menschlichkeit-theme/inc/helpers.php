<?php
// Hilfsfunktionen wie Breadcrumbs und Auto-Navigation
function verein_menschlichkeit_breadcrumbs() {
  if (!is_front_page()) {
    echo '<nav class="breadcrumbs" aria-label="Breadcrumbs">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Startseite', 'verein-menschlichkeit') . '</a> » ';
    if (is_category() || is_single()) {
      the_category(' » ');
      if (is_single()) {
        echo ' » ' . esc_html(get_the_title());
      }
    } elseif (is_page()) {
      echo esc_html(get_the_title());
    }
    echo '</nav>';
  }
}

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
