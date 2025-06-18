<?php
// Shortcodes für Buttons, Infoboxen, Testimonials, Sitemap
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

function verein_infobox_shortcode($atts, $content = null) {
  $atts = shortcode_atts([
    'type' => 'info', // info, success, warning, error
  ], $atts, 'verein_infobox');
  $class = 'infobox infobox-' . esc_attr($atts['type']);
  return '<div class="' . $class . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('verein_infobox', 'verein_infobox_shortcode');

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
