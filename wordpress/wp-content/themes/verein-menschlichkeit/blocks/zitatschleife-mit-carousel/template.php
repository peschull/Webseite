<?php
/**
 * Template für die Zitatschleife mit Carousel
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Hole Block-Felder
$quotes = get_field('quotes');
$auto_play = get_field('auto_play');
$auto_play_speed = get_field('auto_play_speed') ?: 5000;
$show_navigation = get_field('show_navigation');
$show_dots = get_field('show_dots');
?>

<div class="quote-carousel-module" 
     data-autoplay="<?php echo esc_attr($auto_play ? 'true' : 'false'); ?>"
     data-speed="<?php echo esc_attr($auto_play_speed); ?>">
    
    <?php if ($quotes) : ?>
        <div class="quote-carousel">
            <?php foreach ($quotes as $quote) : 
                $text = $quote['quote_text'];
                $author = $quote['author'];
                $role = $quote['role'];
                $image = $quote['author_image'];
            ?>
                <div class="quote-slide">
                    <div class="quote-content">
                        <div class="quote-text">
                            <span class="quote-mark">"</span>
                            <?php echo wp_kses_post($text); ?>
                            <span class="quote-mark">"</span>
                        </div>
                        
                        <div class="quote-author">
                            <?php if ($image) : ?>
                                <div class="author-image">
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                         alt="<?php echo esc_attr($author); ?>"
                                         loading="lazy">
                                </div>
                            <?php endif; ?>
                            
                            <div class="author-info">
                                <div class="author-name"><?php echo esc_html($author); ?></div>
                                <?php if ($role) : ?>
                                    <div class="author-role"><?php echo esc_html($role); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($show_navigation) : ?>
            <button class="carousel-nav prev" aria-label="<?php esc_attr_e('Vorheriges Zitat', 'verein-menschlichkeit'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                </svg>
            </button>
            <button class="carousel-nav next" aria-label="<?php esc_attr_e('Nächstes Zitat', 'verein-menschlichkeit'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                </svg>
            </button>
        <?php endif; ?>
        
        <?php if ($show_dots) : ?>
            <div class="carousel-dots">
                <?php for ($i = 0; $i < count($quotes); $i++) : ?>
                    <button class="dot<?php echo $i === 0 ? ' active' : ''; ?>" 
                            aria-label="<?php echo sprintf(esc_attr__('Gehe zu Zitat %d', 'verein-menschlichkeit'), $i + 1); ?>"
                            data-slide="<?php echo $i; ?>"></button>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
