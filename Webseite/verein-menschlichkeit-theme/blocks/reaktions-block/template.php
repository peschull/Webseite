<?php
/**
 * Template für Reaktions-Block
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$emojis = get_field('emojis');
$block_classes = 'reaktions-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="reaktions-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="reaktions-emojis">
        <?php if ($emojis) : foreach ($emojis as $emoji) : ?>
            <button class="reaktions-emoji" data-emoji="<?php echo esc_attr($emoji['zeichen']); ?>">
                <span><?php echo esc_html($emoji['zeichen']); ?></span>
                <span class="reaktions-count">0</span>
            </button>
        <?php endforeach; endif; ?>
    </div>
</div>
