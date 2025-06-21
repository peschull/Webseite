<?php
/**
 * Shortcodes für das Theme
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 */

// Verhindere direkten Zugriff.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Button Shortcode
 * [verein_button url="#" style="primary" target="_self" size="medium"]Button Text[/verein_button]
 */
function verein_button_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'url' => '#',
        'style' => 'primary',
        'target' => '_self',
        'size' => 'medium',
        'icon' => '',
        'class' => ''
    ], $atts, 'verein_button');
    
    $classes = ['btn'];
    $classes[] = 'btn-' . sanitize_html_class($atts['style']);
    $classes[] = 'btn-' . sanitize_html_class($atts['size']);
    
    if (!empty($atts['class'])) {
        $classes[] = sanitize_html_class($atts['class']);
    }
    
    $button_html = '<a href="' . esc_url($atts['url']) . '" ';
    $button_html .= 'class="' . implode(' ', $classes) . '" ';
    $button_html .= 'target="' . esc_attr($atts['target']) . '"';
    
    if ($atts['target'] === '_blank') {
        $button_html .= ' rel="noopener noreferrer"';
    }
    
    $button_html .= '>';
    
    if (!empty($atts['icon'])) {
        $button_html .= '<span class="btn-icon" aria-hidden="true">' . wp_kses_post($atts['icon']) . '</span>';
    }
    
    $button_html .= wp_kses_post($content);
    $button_html .= '</a>';
    
    return $button_html;
}
add_shortcode('verein_button', 'verein_button_shortcode');

/**
 * Infobox Shortcode
 * [verein_infobox type="info" title="Titel"]Inhalt[/verein_infobox]
 */
function verein_infobox_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'type' => 'info', // info, success, warning, error, tip
        'title' => '',
        'icon' => '',
        'dismissible' => 'false'
    ], $atts, 'verein_infobox');
    
    $classes = ['infobox'];
    $classes[] = 'infobox-' . sanitize_html_class($atts['type']);
    
    if ($atts['dismissible'] === 'true') {
        $classes[] = 'infobox-dismissible';
    }
    
    $infobox_html = '<div class="' . implode(' ', $classes) . '">';
    
    if (!empty($atts['title'])) {
        $infobox_html .= '<div class="infobox-header">';
        
        if (!empty($atts['icon'])) {
            $infobox_html .= '<span class="infobox-icon" aria-hidden="true">' . wp_kses_post($atts['icon']) . '</span>';
        }
        
        $infobox_html .= '<h4 class="infobox-title">' . esc_html($atts['title']) . '</h4>';
        
        if ($atts['dismissible'] === 'true') {
            $infobox_html .= '<button type="button" class="infobox-dismiss" aria-label="' . esc_attr__('Schließen', 'verein-menschlichkeit') . '">&times;</button>';
        }
        
        $infobox_html .= '</div>';
    }
    
    $infobox_html .= '<div class="infobox-content">';
    $infobox_html .= do_shortcode($content);
    $infobox_html .= '</div>';
    $infobox_html .= '</div>';
    
    return $infobox_html;
}
add_shortcode('verein_infobox', 'verein_infobox_shortcode');

/**
 * Testimonials Shortcode
 * [verein_testimonials anzahl="5" kategorie=""]
 */
function verein_testimonials_shortcode($atts) {
    $atts = shortcode_atts([
        'anzahl' => 5,
        'kategorie' => '',
        'style' => 'slider'
    ], $atts, 'verein_testimonials');
    
    $query_args = [
        'post_type' => 'testimonial',
        'posts_per_page' => (int)$atts['anzahl'],
        'orderby' => 'rand',
        'post_status' => 'publish'
    ];
    
    if (!empty($atts['kategorie'])) {
        $query_args['meta_query'] = [
            [
                'key' => 'kategorie',
                'value' => sanitize_text_field($atts['kategorie']),
                'compare' => '='
            ]
        ];
    }
    
    $query = new WP_Query($query_args);
    
    if (!$query->have_posts()) {
        return '<p class="testimonials-empty">' . esc_html__('Keine Testimonials gefunden.', 'verein-menschlichkeit') . '</p>';
    }
    
    ob_start();
    
    if ($atts['style'] === 'slider') {
        ?>
        <div class="testimonials-slider" data-testimonials-slider>
            <div class="slider-track">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="testimonial-slide">
                        <blockquote class="testimonial-quote">
                            <?php the_content(); ?>
                        </blockquote>
                        <div class="testimonial-author">
                            <cite class="testimonial-name"><?php the_title(); ?></cite>
                            <?php if (get_field('position')) : ?>
                                <span class="testimonial-position"><?php the_field('position'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="slider-controls">
                <button type="button" class="slider-prev" aria-label="<?php esc_attr_e('Vorheriges Testimonial', 'verein-menschlichkeit'); ?>">‹</button>
                <button type="button" class="slider-next" aria-label="<?php esc_attr_e('Nächstes Testimonial', 'verein-menschlichkeit'); ?>">›</button>
            </div>
            <div class="slider-dots">
                <?php for ($i = 0; $i < $query->post_count; $i++) : ?>
                    <button type="button" class="slider-dot<?php echo $i === 0 ? ' active' : ''; ?>" data-slide="<?php echo $i; ?>" aria-label="<?php echo sprintf(esc_attr__('Gehe zu Testimonial %d', 'verein-menschlichkeit'), $i + 1); ?>"></button>
                <?php endfor; ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="testimonials-grid">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="testimonial-item">
                    <blockquote class="testimonial-quote">
                        <?php the_content(); ?>
                    </blockquote>
                    <div class="testimonial-author">
                        <cite class="testimonial-name"><?php the_title(); ?></cite>
                        <?php if (get_field('position')) : ?>
                            <span class="testimonial-position"><?php the_field('position'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
    }
    
    wp_reset_postdata();
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
