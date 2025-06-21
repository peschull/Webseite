<?php
/**
 * Template für Drag-Umfrage
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$drag_items = get_field('drag_items');
$drop_zones = get_field('drop_zones');
$block_classes = 'drag-umfrage-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <div class="drag-items">
        <?php if ($drag_items) : foreach ($drag_items as $item) : ?>
            <div class="drag-item"><?php echo esc_html($item['text']); ?></div>
        <?php endforeach; endif; ?>
    </div>
    <div class="drop-zones">
        <?php if ($drop_zones) : foreach ($drop_zones as $zone) : ?>
            <div class="drop-zone">
                <span class="drop-zone-label"><?php echo esc_html($zone['label']); ?></span>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
