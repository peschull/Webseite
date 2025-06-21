<?php
/**
 * Template für Button Row Farbverlauf
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$buttons = get_field('buttons');
$block_classes = 'button-row-farbverlauf';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <div class="button-row">
        <?php if ($buttons) : foreach ($buttons as $button) : ?>
            <a href="<?php echo esc_url($button['link']); ?>" class="button-farbverlauf" target="_blank" rel="noopener noreferrer">
                <?php echo esc_html($button['text']); ?>
            </a>
        <?php endforeach; endif; ?>
    </div>
</div>
