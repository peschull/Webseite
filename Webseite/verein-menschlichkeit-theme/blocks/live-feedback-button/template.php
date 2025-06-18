<?php
/**
 * Template für den Live-Feedback-Button Block
 *
 * @package Verein-Menschlichkeit
 */

$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}

$button_text = get_field('button_text') ?: __('Feedback geben', 'verein-menschlichkeit');
$feedback_options = get_field('feedback_options');
?>

<div class="live-feedback-button <?php echo esc_attr($class_name); ?>">
    <button class="feedback-trigger" type="button">
        <?php echo esc_html($button_text); ?>
        <span class="feedback-icon">📝</span>
    </button>
    
    <div class="feedback-popup" style="display: none;">
        <div class="feedback-popup-header">
            <h3><?php _e('Ihr Feedback', 'verein-menschlichkeit'); ?></h3>
            <button class="close-popup" type="button">&times;</button>
        </div>
        
        <div class="feedback-options">
            <?php if ($feedback_options): ?>
                <?php foreach ($feedback_options as $option): ?>
                    <button class="feedback-option" data-value="<?php echo esc_attr($option['value']); ?>">
                        <?php echo esc_html($option['label']); ?>
                        <?php if (!empty($option['icon'])): ?>
                            <span class="option-icon"><?php echo esc_html($option['icon']); ?></span>
                        <?php endif; ?>
                    </button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <?php if (get_field('allow_comments')): ?>
            <div class="feedback-comment">
                <textarea placeholder="<?php esc_attr_e('Zusätzlicher Kommentar (optional)', 'verein-menschlichkeit'); ?>"></textarea>
            </div>
        <?php endif; ?>
        
        <button class="submit-feedback" type="button">
            <?php _e('Feedback senden', 'verein-menschlichkeit'); ?>
        </button>
    </div>
</div>
