<?php
/**
 * Template für Drag-Kategorisierung
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$drag_items = get_field('drag_items');
$categories = get_field('categories');
$block_classes = 'drag-kategorisierung-block';
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
    <div class="categories">
        <?php if ($categories) : foreach ($categories as $cat) : ?>
            <div class="category-dropzone">
                <span class="category-name"><?php echo esc_html($cat['name']); ?></span>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
