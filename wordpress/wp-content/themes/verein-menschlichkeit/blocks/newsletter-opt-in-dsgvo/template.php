<?php
/**
 * Template für den Newsletter Opt-in DSGVO Block
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Hole Block-Felder
$heading = get_field('heading');
$subheading = get_field('subheading');
$form_id = get_field('form_id') ?: 'newsletter-form';
$success_message = get_field('success_message');
$error_message = get_field('error_message');
$privacy_text = get_field('privacy_text');
$privacy_link = get_field('privacy_link');
$button_text = get_field('button_text') ?: __('Newsletter abonnieren', 'verein-menschlichkeit');
$show_name_field = get_field('show_name_field');
?>

<div class="newsletter-opt-in-module" data-form-id="<?php echo esc_attr($form_id); ?>">
    <?php if ($heading || $subheading) : ?>
        <div class="newsletter-header">
            <?php if ($heading) : ?>
                <h2 class="newsletter-heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            
            <?php if ($subheading) : ?>
                <div class="newsletter-subheading"><?php echo wp_kses_post($subheading); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form id="<?php echo esc_attr($form_id); ?>" class="newsletter-form" method="post">
        <?php if ($show_name_field) : ?>
            <div class="form-group">
                <label for="<?php echo esc_attr($form_id); ?>-name"><?php _e('Name', 'verein-menschlichkeit'); ?></label>
                <input type="text" 
                       id="<?php echo esc_attr($form_id); ?>-name" 
                       name="name" 
                       placeholder="<?php esc_attr_e('Ihr Name', 'verein-menschlichkeit'); ?>"
                       required>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="<?php echo esc_attr($form_id); ?>-email"><?php _e('E-Mail', 'verein-menschlichkeit'); ?></label>
            <input type="email" 
                   id="<?php echo esc_attr($form_id); ?>-email" 
                   name="email" 
                   placeholder="<?php esc_attr_e('Ihre E-Mail-Adresse', 'verein-menschlichkeit'); ?>"
                   required>
        </div>

        <div class="form-group checkbox-group">
            <input type="checkbox" 
                   id="<?php echo esc_attr($form_id); ?>-privacy" 
                   name="privacy" 
                   required>
            <label for="<?php echo esc_attr($form_id); ?>-privacy">
                <?php if ($privacy_text && $privacy_link) : ?>
                    <?php echo wp_kses_post(sprintf(
                        $privacy_text,
                        '<a href="' . esc_url($privacy_link) . '" target="_blank" rel="noopener noreferrer">',
                        '</a>'
                    )); ?>
                <?php else : ?>
                    <?php _e('Ich stimme der Verarbeitung meiner Daten gemäß der Datenschutzerklärung zu.', 'verein-menschlichkeit'); ?>
                <?php endif; ?>
            </label>
        </div>

        <div class="form-group">
            <button type="submit" class="newsletter-submit">
                <span class="button-text"><?php echo esc_html($button_text); ?></span>
                <div class="loading-spinner"></div>
            </button>
        </div>

        <div class="form-messages">
            <div class="success-message" style="display: none;">
                <?php echo wp_kses_post($success_message ?: __('Vielen Dank für Ihre Anmeldung! Bitte bestätigen Sie Ihre E-Mail-Adresse über den Link, den wir Ihnen soeben geschickt haben.', 'verein-menschlichkeit')); ?>
            </div>
            <div class="error-message" style="display: none;">
                <?php echo wp_kses_post($error_message ?: __('Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.', 'verein-menschlichkeit')); ?>
            </div>
        </div>

        <?php wp_nonce_field('newsletter_opt_in', 'newsletter_nonce'); ?>
    </form>
</div>
