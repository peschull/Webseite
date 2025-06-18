<?php
/**
 * Template für Cookie-Wahl
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$text = get_field('cookie_text');
$options = get_field('cookie_options');
$block_classes = 'cookie-wahl-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <div class="cookie-text"><?php echo esc_html($text); ?></div>
    <?php if ($options) : ?>
        <div class="cookie-options">
            <?php foreach ($options as $option) : ?>
                <button class="cookie-option" data-value="<?php echo esc_attr($option['value']); ?>">
                    <?php echo esc_html($option['label']); ?>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
