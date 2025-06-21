<?php
/**
 * Template für Engagementradar
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$items = get_field('engagement_items');
$block_classes = 'engagementradar-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($items) : ?>
        <ul class="engagementradar-liste">
            <?php foreach ($items as $item) : ?>
                <li class="engagementradar-item">
                    <span class="engagementradar-label"><?php echo esc_html($item['label']); ?>:</span>
                    <span class="engagementradar-value"><?php echo esc_html($item['value']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
