<?php
/**
 * Template für den Hero Section mit Call-to-Action Scroll Trigger Block
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Hole Block-Felder
$title = get_field('title');
$subtitle = get_field('subtitle');
$background_image = get_field('background_image');
$cta_text = get_field('cta_text');
$cta_link = get_field('cta_link');
?>

<div class="hero-section-scroll-trigger">
    <?php if ($background_image) : ?>
        <div class="hero-background" style="background-image: url(<?php echo esc_url($background_image['url']); ?>)">
            <div class="hero-overlay"></div>
        </div>
    <?php endif; ?>
    
    <div class="hero-content">
        <?php if ($title) : ?>
            <h1 class="hero-title"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>
        
        <?php if ($subtitle) : ?>
            <div class="hero-subtitle"><?php echo wp_kses_post($subtitle); ?></div>
        <?php endif; ?>
        
        <?php if ($cta_text && $cta_link) : ?>
            <div class="hero-cta">
                <a href="<?php echo esc_url($cta_link); ?>" class="cta-button scroll-trigger">
                    <?php echo esc_html($cta_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
