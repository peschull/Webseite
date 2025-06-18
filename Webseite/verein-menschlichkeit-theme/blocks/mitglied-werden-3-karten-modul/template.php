<?php
/**
 * Template für das Mitglied werden 3-Karten-Modul
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Hole Block-Felder
$heading = get_field('heading');
$subheading = get_field('subheading');
$cards = get_field('membership_cards');
?>

<div class="membership-cards-module">
    <?php if ($heading || $subheading) : ?>
        <div class="membership-cards-header">
            <?php if ($heading) : ?>
                <h2 class="membership-heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            
            <?php if ($subheading) : ?>
                <div class="membership-subheading"><?php echo wp_kses_post($subheading); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($cards) : ?>
        <div class="membership-cards-container">
            <?php foreach ($cards as $index => $card) : 
                $is_highlighted = $card['is_highlighted'];
                $membership_type = $card['membership_type'];
                $price = $card['price'];
                $price_period = $card['price_period'];
                $features = $card['features'];
                $cta_text = $card['cta_text'];
                $cta_link = $card['cta_link'];
            ?>
                <div class="membership-card <?php echo $is_highlighted ? 'highlighted' : ''; ?>">
                    <?php if ($is_highlighted) : ?>
                        <div class="highlight-badge"><?php _e('Beliebt', 'verein-menschlichkeit'); ?></div>
                    <?php endif; ?>
                    
                    <div class="membership-card-header">
                        <h3 class="membership-type"><?php echo esc_html($membership_type); ?></h3>
                        <?php if ($price) : ?>
                            <div class="membership-price-container">
                                <span class="membership-price"><?php echo esc_html($price); ?></span>
                                <?php if ($price_period) : ?>
                                    <span class="membership-price-period"><?php echo esc_html($price_period); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($features) : ?>
                        <ul class="membership-features">
                            <?php foreach ($features as $feature) : ?>
                                <li class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <?php echo esc_html($feature['feature']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if ($cta_text && $cta_link) : ?>
                        <div class="membership-cta">
                            <a href="<?php echo esc_url($cta_link); ?>" 
                               class="cta-button"
                               data-membership-type="<?php echo esc_attr($membership_type); ?>">
                                <?php echo esc_html($cta_text); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
