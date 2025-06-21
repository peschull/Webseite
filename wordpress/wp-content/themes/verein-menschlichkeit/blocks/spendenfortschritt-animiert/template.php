<?php
/**
 * Template für den Spendenfortschritt Animiert Block
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Hole Block-Felder
$title = get_field('title');
$description = get_field('description');
$current_amount = get_field('current_amount') ?: 0;
$target_amount = get_field('target_amount') ?: 100;
$currency = get_field('currency') ?: '€';
$display_style = get_field('display_style') ?: 'bar';
$color_scheme = get_field('color_scheme') ?: 'green';
$show_details = get_field('show_details') ?: false;
$animation_duration = get_field('animation_duration') ?: 1500;

// Berechne Prozentsatz
$percentage = min(($current_amount / $target_amount) * 100, 100);
?>

<div class="spendenfortschritt-module <?php echo esc_attr($display_style); ?> <?php echo esc_attr($color_scheme); ?>"
     data-percentage="<?php echo esc_attr($percentage); ?>"
     data-duration="<?php echo esc_attr($animation_duration); ?>">
    
    <?php if ($title || $description) : ?>
        <div class="spendenfortschritt-header">
            <?php if ($title) : ?>
                <h2 class="spendenfortschritt-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            
            <?php if ($description) : ?>
                <div class="spendenfortschritt-description"><?php echo wp_kses_post($description); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="spendenfortschritt-container">
        <?php if ($display_style === 'bar') : ?>
            <div class="progress-bar-container">
                <div class="progress-bar" role="progressbar" 
                     aria-valuenow="<?php echo esc_attr($percentage); ?>"
                     aria-valuemin="0" 
                     aria-valuemax="100">
                    <div class="progress-fill"></div>
                    <span class="progress-text">
                        <span class="percentage">0</span>%
                    </span>
                </div>
            </div>
        <?php elseif ($display_style === 'circle') : ?>
            <div class="progress-circle-container">
                <svg class="progress-circle" viewBox="0 0 36 36">
                    <path d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831"
                        fill="none"
                        stroke="#eee"
                        stroke-width="3" />
                    <path class="progress-circle-fill" d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831"
                        fill="none"
                        stroke-width="3" />
                </svg>
                <div class="progress-circle-text">
                    <span class="percentage">0</span>%
                </div>
            </div>
        <?php endif; ?>

        <?php if ($show_details) : ?>
            <div class="spendenfortschritt-details">
                <div class="amount-current">
                    <?php echo esc_html(number_format($current_amount, 0, ',', '.')); ?><?php echo esc_html($currency); ?>
                    <span class="amount-label"><?php _e('Aktuell', 'verein-menschlichkeit'); ?></span>
                </div>
                <div class="amount-target">
                    <?php echo esc_html(number_format($target_amount, 0, ',', '.')); ?><?php echo esc_html($currency); ?>
                    <span class="amount-label"><?php _e('Ziel', 'verein-menschlichkeit'); ?></span>
                </div>
            </div>
            
            <div class="spendenfortschritt-message">
                <?php if ($percentage >= 100) : ?>
                    <div class="success-message">
                        <?php _e('Ziel erreicht! Vielen Dank für Ihre Unterstützung!', 'verein-menschlichkeit'); ?>
                    </div>
                <?php else : ?>
                    <div class="remaining-amount">
                        <?php
                        $remaining = $target_amount - $current_amount;
                        printf(
                            __('Noch %s%s bis zum Ziel', 'verein-menschlichkeit'),
                            number_format($remaining, 0, ',', '.'),
                            $currency
                        );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
